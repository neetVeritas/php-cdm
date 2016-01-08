# php-cdm | PHP Content Delivery Manager
> This project is a very simple and lightweight solution to resource allocation on limited PHP workspaces. No need for composer, or any other applications of the sort. It is a revised version of my earlier project, 'php-js-loader' also including CSS and CSS minification.

This content delivery manager was created with one idea in mind, simplicity. Working on a front end application on a typical, limited LAMP workspace? No worries. The CDM takes care of both your scripts and style references. Stylesheet's are minimized using [Joe Scylla's CSS minifier](https://code.google.com/p/cssmin/), and all scripts are packed using [Dean Edwards Parse Master](http://dean.edwards.name/weblog/2006/12/packer-php/).

***Note:*** *This project was developed using **php5**. Though it should be function with previous versions, I have not personally ran any tests.*

# Getting Started
Take for example the following project directory tree,
```
app/
----- shared/
---------- sidebar/
--------------- sidebarDirective.js
--------------- sidebarView.html
---------- article/
--------------- articleDirective.js
--------------- articleView.html
----- components/
---------- home/
--------------- homeController.js
--------------- homeService.js
--------------- homeView.html
---------- blog/
--------------- blogController.js
--------------- blogService.js
--------------- blogView.html
----- app.module.js
----- app.routes.js
assets/
----- img/
----- css/
--------------- main.css
--------------- navbar.css
----- js/
----- libs/
index.html
```

You would normally need to reference every single resource like so,
```html
<head>
  <script src=".../controller1.js"></script>
  <script src=".../directive1.js"></script>
  <script src=".../utility1.js"></script>
  <link rel="stylesheet" type="text/css" href="../main.css">
  <link rel="stylesheet" type="text/css" href="../navbar.css">
</head>
```
Which would obviously become quite tedious. With the CDM, instead, we can just pre-define all our resources and query them together in a compressed context. Resources can be defined in the **scripts** and **styles** JSON documents located within the ***cdm/resources/...*** directory. These JSON documents are structured like so,
```json
{
  "Initialize": {
    "enabled": true,
    "local": true,
    "list": [
      {
        "name": "Module",
        "enabled": true,
        "source": "/app/module.js"
      },
      {
        "name": "Routes",
        "enabled": true,
        "source": "/app/routes.js"
      }
    ]
  }
}
```
Multiple resource branches can be defined, and resources can either be enabled by branch or individually, simply by switching the **enabled** property associated with their object. It should also be taken note of, that the CDM fetches resources in linear order.

Once your resources have been defined, you can include them easily in your project like so,
```html
<head>
  <script type="text/javascript" src="cdm/fetch.php?resource=scripts"></script>
  <link rel="stylesheet" type="text/css" href="cdm/fetch.php?resource=styles">
</head>
```
The CDM fetch script will then crunch and compress your resources, and automatically convert the http request's MIME type for appropriate usage.
