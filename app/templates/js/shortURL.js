var express = require('express');
var path = require('path');
var nunjucks = require('nunjucks');
var shorturl = require('shorturl');
var mongoose = require('mongoose');
var port = 3000;

var app = express();
var server = require('http').createServer(app);
var io = require('socket.io').listen(server);

app.use(express.static(path.join(__dirname, 'public')));

nunjucks.configure('views', {
    autoescape: true,
    express: app
});

mongoose.connect(' mongodb://donb15:handball*15@ds037581.mongolab.com:37581/short_url', function (error) {
    if (error) {
        console.log(error);
    }
});

var UrlShortnerSchema = new mongoose.Schema({
    url: String,
    shortenUrl: String
});
var UrlShortner = mongoose.model('urlshortners', UrlShortnerSchema);

app.get('/', function (req, res) {
    
	res.render('index.html', {});
})

.get('/admin', function (req, res) {

	res.render('admin.html', {});
})

.use(function (req, res, next) {
    res.status(404).render('404.html');
});

io.sockets.on('connection', function (socket) {
    socket.on('message', function (message) {
        shorturl(message, function (result) {
        	socket.emit('message', {message: message + ' => <a href="' + result + '">' + result + '</a>'});
            var shorten = new UrlShortner({
                url: message,
                shortenUrl: result
            });
            shorten.save(function (error) {
                if (error) {
                    console.log(error);
                }
            });
    	});
    });

    UrlShortner.find({}, function (error, docs) {
        socket.emit('length', {length: docs.length});
        docs.forEach(function (entry) {
            socket.emit('docs', {url: entry.url, shortenUrl: entry.shortenUrl});
        });
    });
});

server.listen(port);
