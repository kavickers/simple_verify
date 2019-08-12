const Discord = require('discord.js');
const client = new Discord.Client();
const token = require('./settings.json').token;
const settings = require('./settings.json');
const mysql = require('mysql');

//more client.on's!! client.on('', =>{});


var pool = mysql.createPool({
    host: settings.sqlhost,
    user: settings.sqluser,
    password: settings.sqlpass,
    database: settings.sqldb
});


client.on('ready',() => {
    console.log('I\'m Online\nI\'m Online');
    client.user.setGame(";verify token");
    client.user.setStatus("dnd");
});

var prefix = ";"



client.on('message', message => {
    if (message.author.equals(client.user)) return;

    if (!message.content.startsWith(prefix)) return;

    var args = message.content.substring(prefix.length).split(" ");

    switch (args[0].toLowerCase()) { 
        case "verify":
            if (message.channel.type === "dm") {
                pool.query(`SELECT * FROM Users`, function(error, results, fields) {
                
                if (error) return error;

                let data = results.map((child) => child.discordToken).indexOf(args[1])

                if (data > -1) {
                 console.log(results[data]); // set username of discord user to results[data].name (or .username, however u have it)
                 message.channel.send("Hi, " + results[data].Username + "! Thank you for verifying with us! You may now speak in all text channels.");
                 client.guilds.get("289924100992794634").member(message.author).addRole("289924764716498944");
                 client.guilds.get("289924100992794634").member(message.author).setNickname(results[data].Username);
                } else {
                 message.channel.send("Invalid token!");
                };
              });
               
                return;
                } else {
                message.delete();
                message.channel.send("You must DM your verification code!");
                return;
                }
            break;
        default:
            message.channel.send("Sorry, that's an invalid command.");
    }
});

client.login(token);
