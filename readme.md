<div align="center">
<a href="https://github.com/iambrennanwalsh/ToDone">
<img src="https://raw.githubusercontent.com/iambrennanwalsh/ToDone/development/public/images/logo.png?token=AJWECM5ED4JV4HOHMLHMDCS5K3GOW" alt="Logo" height="30">
</a>
<h3 align="center">ToDone!</h3>
<p align="center">
An awesome new productivity app!
<br />
<a href="https://todone.local">View Site</a> 
. 
<a href="https://github.com/iambrennanwalsh/ToDone/issues">Report Bug</a>
</p>
</div>


## Table of Contents

* [About ToDone!](#about-todone-)
* [Technology](#technology)
* [To Do](#to-do)

## About ToDone!

[![ToDone! Screen Shot][product-screenshot]](https://todone.local)

ToDone! was a learning experience. This app represents my first steps in full stack web development. It's been refactored and embellished on quite a bit, but the end result is a simple app, which properly introduced me to the fundamentals of web application development.

The app itself is a productivity application. The core concept of Trello seemed like an easy enough project to emulate. So I worked on it for a bit. Set it aside for a few months. Came back to it. Set it aside. And finally I uploaded what I considered a "finished" product.

Some of the features:
* Fully functional authentication system (Login, Logout, Register, Forgot My Password, Reset Password, Confirm Your Email).
* User profile system with users able to update their account info, and even delete their account.
* Dashboard system where users can create an unlimited amount of boards.
* Each Board can hold any number of rearangeable lists.
* Each list can hold any number of rearangeable cards, which can move from list to list.

I first began work on this application a long time ago. I have since moved on to bigger projects, and don't think I will be updating this application anymore in the future. Theres work to be done on it, but I don't see the point in working on it. This app was an introduction for myself to web application development. It served it purpose. Now it serves as a proud member of my portfolio as well as a demo application for any students of Symfony 4 and Vue.js.

## Technology
At it's core, ToDone! is a Symfony 4 and Vue.js application. But as is often the case with modern web dev, an extensive variety of dependencies have found themselves mixed in. The following is a somewhat complete list of these dependencies.

**Backend Dependencies**
* [Symfony 4](https://symfony.com) - Core application framework.
* [Doctrine ORM](https://doctrine-project.com) - Database management.
* [Twig](https://twig.symfony.com) - Templating.
* [Api Platform](https://api-platform.com/) - Rest API abstraction.
* [Composer](https://getcomposer.org/) - Dependency manager for PHP. 

**Frontend Dependencies**
* [Vue.js](https://vuejs.org) - Front end application framework.
* [Bulma](https://bulma.io) - CSS framework.
* [Sass](https://sass-lang.com) - Syntactically awesome style sheets.
* [Webpack](https://webpack.js.org) - Dependency bundler.
* [Babel](https://babeljs.io) - JavaScript compiler.
* [npm](https://npmjs.com) - Dependency manager for javascript.
* [Font Awesome](https://npmjs.com) - Awesomely simple web icons.

**Deployment**
* [Nginx](https://nginx.com) - Web server.
* [Heroku](https://heroku.com) - Application hosting, and deployment.
* [Github](https://github.com) - GIT version control hosting.

## To Do

- [ ] Organize css code.
- [ ] Redo the dashboard css and make ux more user friendly (esspecially on mobile).
- [ ] Impliment an in-browser cacheing solution to reduce ajax requests sent to server.

[product-screenshot]: public/images/screenshot.png
