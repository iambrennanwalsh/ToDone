# ToDo!
Just another productivity app.

--------

## About
ToDo! Is a learning experience. I was learning Vue.js and I wanted some real world experience applying it to a Symfony project. So I thought why not make something useful for myself and maybe others, I'll make a productivity app. The result is ToDo! 

--------

ToDo! provides users with the ability to create simple lists, where they can check off tasks. Not exactly complex, but it's a strong boilerplate for future expansion, and ideas.

ToDo utilizes the following technologies..

**Symfony 4**: Server Side PHP Framework
**Vue.js**: Client Side JavaScript Framework
**Bulma**: CSS Framework
**Webpack**: Build Tool
**Sass**: CSS Preprocessing
**NPM**: Frontend Dependencies
**Composer**: Server Side Dependencies
**Twig**: Templating

--------

## Sections
I've split ToDo! into multiple 'sections' simply to better organize the idea and code. These sections are **Frontend**, **Authentication**, **Dashboard**, and **Utility**. Lets break them down.

--------

**1. Frontend**:
- The public facing section of the site. The home page, about us, contact page, plus terms and conditions and privacy policy are all part of the frontend section.

**2. Authentication**:
- The authentication section of ToDo! handles all of the user authenticating. That is the signing in, signing up, and signing out of our users. 

**3. Dashboard**:
- The dashboard is the the app. It's where users will create and edit their lists, and alter their profile information.

**4. Utility**:
- While the utility section isn't accesible, it's very important. This section contains all of the ajax code, modals, as well as the email templates.

--------

## Assets
Here I cover the proper development procedure for our assets. 

--------

ToDo! has three sets of assets..

**1. SCSS**
**2. JavaScript**
**3. Vue.js**

For each of these sets of assets, you'll find a folder within the /assets directory. If you look inside these folders you'll see the following structure.

- front._ 
- /front/
- auth._
- /auth/
- dash.js
- /dash/
- base._

ToDo! uses webpack to compile all of our assets and dependencies into bundled files. Webpack takes all of the scss, js, and vue files and then builds one css and js file per site section(front, auth, dash). It takes 3 entry points (within /assets/js)..

- front.js 
- auth.js
- dash.js

These are the starting points for webpack, and so these files import all of the dependency that each site section needs.


For example the front.js file looks like this..

require('../css/front.scss'); 
require('./base.js');
require('../vue/front.vue');
require('./front/scripts.front.js');

Starting from the 1st line..

**1. require('../css/front.scss');**
- This is the front.scss file within the /assets/css folder. This Scss file then imports all of it's own scss dependencies following the same logic as the javascript side does. 

**2. require('./base.js');**
- Base.js contains all of the sitewide javascript dependencies. Any js that is implemented across all sections should go in here. 

**3. require('../vue/front.vue');**
- This is the front.vue file within the /assets/vue folder. This .vue file then imports all of it's own dependencies following the same logic as the javascript side does. 

**4. require('./front/scripts.front.js');**
- script.front.js is where you would put all of your js that is specific to the front end of the site. It is only loaded in front.js. Auth.js loads in scripts.auth.js.

To run webpack and bundle our assets open your command line and cd into the root. Then run the following command.

**npm run webpack**

That will bundle the files. You'll find these bundled files within the /public/build folder. This is within the web root and so accessible via the browser, unlike /assets.

In public/build you'll now find..

- front.js 
- front.css
- auth.js
- auth.css
- dash.js
- dash.css

--------

## Deployment
An overview of the proper deployment guidelines.

--------

We run ToDo! on **Heroku**. Heroku makes the deployment process a breeze.  Before I explain,  you have to first understand the diffrrent enviroments ToDo! exists in..

**Development**
- This is where I build the app. The local enviroment. My mac. 

**Staging**
- The staging enviroment is for testing how the app performs on a  production server. The staging and production enviroments are nearly identical. So It allows us to test how the production app will perform before we deploy it to production. 

**Production**
- The live, published enviroment. We deploy to  production once we've tested the staging  enviroment thoroughly.

So heres how the deployment process works..

### Github + Heroku

Our apps git repository is made up of 3 main branches. Development, Staging, and Production. The development branch is pretty much always checked out. 

Once our development enviroment is ready for staging. We stage and commit all new file changes, and run **git push origin staging**. 

This will update the staging branch on github. Heres where it gets cool..

Heroku is connected to both the staging and production branches on github. When it detects a new commit, it automatically pulls the repository into the connected enviroment. 

So basically deploying is as easy as running **git push origin production**. Or as easy as clicking a button in GitKraken. :).

--------

## Templating

--------

ToDo!'s templates are built using Twig with a little bit of Vue.js sprinkled around.

The templating system follows the asset system for the most part. Three top level templates, front.twig, auth.twig, and dash.twig provide the building blocks that front/contact.twig, and auth/login.twig expand on.

All forms have are built with a form class in Symfony. This simplifies the error output, and server side validation. Speaking of validation. All forms go through extensive client side and server side validation. Users are sneaky, no tricks get through,

Vue.js provides a nice later of simple reactivity to our twig templating so we use alot of Vue components within our twig templates.

--------

## Routing

--------

Our routing is handled by Symfony, and I think it will stay that way. I may implement Vue routing just for the experience of it, but I feel as though that destorys all the Crud I've built.



