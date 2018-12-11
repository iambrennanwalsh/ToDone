# ToDo!
Just another to do list app.

## About
ToDo! Is a learning experience. I wanted to build a complex web application all by myself to stimulate and grow my coding abilites in PHP and JavaScript.

----

What ToDo! does is provide users with simple lists, where they can check off tasks. It's a strong boilerplate for future expansion, and ideas.

ToDo utilizes the following technologies..

**Symfony 4**: Server Side PHP Framework
**Vue.js**: Client Side JavaScript Framework
**Bulma**: CSS Framework
**Webpack**: Build Tool
**Sass**: CSS Preprocessing
**NPM**: Frontend Dependencies
**Composer**: Server Side Dependencies
**Twig**: Templating


## Sections
ToDo! Is split into multiple 'sections' simply for better code and idea organization. There are 4 sections. Frontend, Authentication, Dashboard, and Utility. Lets break them down.

----

**1. Frontend**:
- The public facing section of the site. IE the home, about us, and contact routes, are the main entry points of the frontend section.

**2. Authentication**:
- The authentication section of ToDo! handles all of the user authenticating. That is the signing in, signing up, and signing out of our users. 

**3. Dashboard**:
- The dashboard is the meat of the app. It contains each users lists, and their profile information.

**4. Utility**:
- The utility section isn't so much a section. What it really is, is a collection of methods. Methods mainly for the server side handling of the apps ajax requests.


## Assets
Here I cover the proper development procedure for our assets. 

--------

ToDo! uses webpack to compile all of our assets and dependencies into bundled files. Webpack builds one bundled css and js file,  per site section(front, auth, dash). It takes 3 entry points (within /assets/js)..

- front.js 
- auth.js
- dash.js

Each of these files will  look like the following..

require('../css/front.scss'); 
require('./base.js');
require('../vue/front.vue');
require('./front/scripts.front.js');

Starting from the 1st line..

**1. require('../css/front.scss');**
- This is the equivelant SCSS file within the /assets/css folder. This Scss file then imports all of it's own scss dependencies following the same logic as the javascript side does. 

**2. require('./base.js');**
- Base.js contains all of the sitewide javascript dependencies. Any js that is implemented across all sections should go in here. 

**3. require('../vue/front.vue');**
- This is the equivelant .vue file within the /assets/vue folder. This .vue file then imports all of it's own dependencies following the same logic as the javascript side does. 

**4. require('./front/scripts.front.js');**
- script.front.js is where you would put all of your js that is specific to the front end of the site. It is only loaded in front.js. Auth.js loads in scripts.auth.js.

To run webpack and bundle our assets open your command line and cd into the root. Then run the following command.

**npm run webpack**

That will  compile the files. You'll find these bundled files within the /public/build folder. This is within the web root and so accessible via the browser, unlike /assets.


## Deployment
An overview of the proper deployment guidelines.

---

We run ToDo! on **Heroku**. Heroku makes the deployment process a breeze.  Before I explain,  you have to first understand the diffrrent enviroments ToDo! exists in..

**Development**
- This is where I build the app. The local enviroment. My mac. 

**Staging**
- The staging enviroment is for testing how the app performs on a  production server. The staging and production enviroments are nearly identical. So It allows us to test how the production app will perform before we deploy it to production. 

**Production**
- The live, published enviroment. We deploy to  production once we've tested the staging  enviroment thoroughly.

So heres how the deployment process works..

### Github + Heroku

Our apps git repository is made up of 3 main branches. Development, Staging, and Primary. The development branch is pretty much always checked out. 

Once our development enviroment is ready for staging. We stage and commit all new file changes, and run **git push origin staging**. 

This will update the staging branch on github. Heres where it gets cool..

Heroku is watching both the staging and production branches, When it detects a new commit, it automatically pulls the repository the changed enviroment. 

So basically deploying is as easy as running **git push origin production**. Or as easy as clicking a button in GitKraken.



## Templating
Not written yet..

---


## Routing
Not written yet..

---


## Checklist
A simple overview of my progress in building the app. 

---

### Frontend
- [x] Home
- [x] About
- [x] Contact
- [ ] Privacy
- [ ] Terms and Conditions

### Authentication
- [ ] Sign In
- [ ] Log Out
- [ ] Sign Up
- [ ] Forgot Password

### Dashboard
- [ ] Profile
- [ ] Lists
- [ ] List
