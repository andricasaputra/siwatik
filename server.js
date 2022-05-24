const { default: makeWASocket, useSingleFileAuthState, DisconnectReason, fetchLatestBaileysVersion, generateForwardMessageContent, prepareWAMessageMedia, generateWAMessageFromContent, generateMessageID, downloadContentFromMessage, makeInMemoryStore, jidDecode, proto } = require("@adiwajshing/baileys")
const pino = require('pino')
const { Boom } = require('@hapi/boom')
const fs = require('fs')
const chalk = require('chalk')
require('dotenv/config')
const express = require('express')
const socket = require("socket.io");
const { toDataURL } = require('qrcode')
const mysql = require('mysql');
require('dotenv').config();
const request = require('request');

const app = express()
const host = process.env.HOST
const port = parseInt(process.env.PORT);
app.use(express.urlencoded({ extended: true }))
app.use(express.json())
const ser = app.listen(port, host, () => {
    console.log(`Server is listening on http://${host}:${port}`)
})

const io = socket(ser);

const db = mysql.createPool({
    host: process.env.DB_HOSTNAME,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE
});

db.getConnection((err) => {
    if (err) throw err;
    console.log('Mysql Connected...');
});

const sessionMap = new Map()

async function startDEVICE(idevice) {

    const store = makeInMemoryStore({ logger: pino().child({ level: 'silent', stream: 'store' }) })

    const { state, saveState } = useSingleFileAuthState(`./app_node/session/device-${idevice}.json`)

    const sock = makeWASocket({
        logger: pino({ level: 'silent' }),
        printQRInTerminal: true,
        browser: ['SIWATIK', 'Safari', '1.0.0'],
        auth: state
    })

    store.bind(sock?.ev)

    sock.decodeJid = (jid) => {

        if (!jid) return jid

        if (/:\d+@/gi.test(jid)) {

            let decode = jidDecode(jid) || {}

            return decode.user && decode.server && decode.user + '@' + decode.server || jid

        } else return jid;
    }

    sock?.ev.on('messages.upsert', async chatUpdate => {

        try {
            newMessage = chatUpdate.messages[0]
            if (!newMessage.message) return
            newMessage.message = (Object.keys(newMessage.message)[0] === 'ephemeralMessage') ? newMessage.message.ephemeralMessage.message : newMessage.message
            if (newMessage.key && newMessage.key.remoteJid === 'status@broadcast') return
            if (newMessage.key.id.startsWith('BAE5') && newMessage.key.id.length === 16) return
            require("./app_node/lib/handler")(sock, chatUpdate, db)
        } catch (err) {
            console.log(err)
        }

    });

    sock?.ev.on('connection.update', async (update) => {

        const { connection, lastDisconnect, qr } = update

        if (connection === 'open') {

            const sess = sessionMap.set(idevice, { sock, store })

            io.emit('message', {
                id: idevice,
                text: 'Whatsapp is ready!'
            });

            io.emit('authenticated', {
                id: idevice,
                data: sock?.user
            })
        }

        if (connection === 'close') {

            io.emit(`logout-${idevice}`, {
                id: idevice,
                text: '<h2 class="text-center text-info mt-4">Logout Success, Lets Scan Again<h2>'
            });
            
            const logoutsessi = () => {
                sock?.logout();
                if (fs.existsSync(`./app_node/session/device-${idevice}.json`)) {
                    fs.unlinkSync(`./app_node/session/device-${idevice}.json`);
                }
            }

            sessionMap.delete(idevice)

            let reason = new Boom(lastDisconnect?.error)?.output.statusCode
            if (reason === DisconnectReason.badSession) { console.log(`Bad Session File, Please Delete Session and Scan Again`); logoutsessi(); }
            else if (reason === DisconnectReason.connectionClosed) { console.log("Connection closed, reconnecting...."); startDEVICE(idevice); }
            else if (reason === DisconnectReason.connectionLost) { console.log("Connection Lost from Server, reconnecting..."); startDEVICE(idevice); }
            else if (reason === DisconnectReason.connectionReplaced) { console.log("Connection Replaced, Another New Session Opened, Please Close Current Session First"); logoutsessi(); }
            else if (reason === DisconnectReason.loggedOut) { console.log(`Device Logged Out, Please Scan Again And Run.`); logoutsessi(); }
            else if (reason === DisconnectReason.restartRequired) { console.log("Restart Required, Restarting..."); startDEVICE(idevice) }
            else if (reason === DisconnectReason.timedOut) { console.log("Connection TimedOut, Reconnecting..."); startDEVICE(idevice); }
            else sock?.end(`Unknown DisconnectReason: ${reason}|${connection}`)
        }

        if (update.qr) {
            const url = await toDataURL(qr)
            try {
                io.emit('qr', {
                    id: idevice,
                    src: url
                });
                io.emit('message', {
                    id: idevice,
                    text: 'QR Code received, scan please!'
                });
            } catch {
                io.emit('message', {
                    id: idevice,
                    text: 'QR Error, please refresh page!'
                });
                logoutDEVICE(idevice)
            }
        }

        console.log('Connected...', update)
    })

    sock?.ev.on('creds.update', saveState);

    sock?.ev.on('contacts.set', async ({ contacts }) => {

        const groups = contacts.filter((c) => c.id.includes('@g.us'));

        await saveGroups(sock, idevice, groups);
         
    });

    sock?.ev.on('contacts.upsert', async (contacts) => {

        await savePersonContact(sock, idevice, contacts);
    });

    return sock;
}

const saveGroups = async (sock, idevice, groups) => {

    var newGroups = [];

    for (let group of groups) {
        
      try{

        let pp = await sock.profilePictureUrl(group.id);
        newGroups.push({...group, pp});

      }catch(err){
        newGroups.push({...group, "pp" : "blank.png"});
      }
    }

    const options = {
        url: process.env.BASE_WEB + '/app/api/get_groups',
        method: "POST",
        json: {
            "id": idevice,
            "data": newGroups
        }
    };

    await request(options, function(error, response, body){
    });

}

const savePersonContact = async (sock, idevice, contacts) => {

    var newContacts = [];

    for (let contact of contacts) {
        
      try{

        let pp = await sock.profilePictureUrl(contact.id);
        newContacts.push({...contact, pp});

      }catch(err){
        newContacts.push({...contact, "pp" : "blank.png"});
      }
    }

    const options = {
        url: process.env.BASE_WEB + '/app/api/get_contacts',
        method: "POST",
        json: {
            "id": idevice,
            "data": newContacts
        }
    };

    await request(options, function(error, response, body){
    })
}

const logoutDEVICE = (idevice) => {
    const sess = sessionMap.get(idevice)
    sess.sock?.logout();
    if (fs.existsSync(`./app_node/session/device-${idevice}.json`)) {
        fs.unlinkSync(`./app_node/session/device-${idevice}.json`);
    }
    sessionMap.delete(idevice)
}

io.on('connection', function (socket) {
    socket.on('create-session', function (data) {
        if (sessionMap.has(parseInt(data.id))) {
            console.log('get session: ' + data.id);
            const conn = sessionMap.get(parseInt(data.id)).sock
            io.emit('message', {
                id: data.id,
                text: 'Whatsapp is ready!'
            });
            io.emit('authenticated', {
                id: data.id,
                data: conn.user
            })
        } else {
            console.log('Create session: ' + data.id);
            startDEVICE(data.id);
        }
    });

    socket.on('logout', async function (data) {
        if (fs.existsSync(`./app_node/session/device-${data.id}.json`)) {
            socket.emit('isdelete', {
                id: data.id,
                text: '<h2 class="text-center text-info mt-4">Logout Success, Lets Scan Again<h2>'
            })
            logoutDEVICE(data.id)
        } else {
            socket.emit('isdelete', {
                id: data.id,
                text: '<h2 class="text-center text-danger mt-4">You are have not Login yet!<h2>'
            })
        }
    })
});

app.get('/contacts', (req, res) => {
    res.status(200).json({ data : req.body.number });
})

require('./app_node/routes/web')(app, sessionMap, startDEVICE)
require('./app_node/lib/cron')(db, sessionMap)

let file = require.resolve(__filename)

fs.watchFile(file, () => {
    fs.unwatchFile(file)
    console.log(chalk.redBright(`Update ${__filename}`))
    delete require.cache[file]
    require(file)
});

process.on('uncaughtException', function (err) {
  console.log('Caught exception: ', err);
})
