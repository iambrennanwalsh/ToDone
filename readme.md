# ToDo!
Another to do list app. Elegantly made to be simple and easy to use. Sign up and start crossing off your list.

**Built on**:
- Symfony 4
- Vue.js
- Bulma

## To Do List
- Create privacy policy and terms and conditions text.
- Create proper form validation for contact, signup, and login.
- Implement forgot password function.
- Implement confirm email function.
- Implement responsive styling.

## Checklist

### Frontend
- [x] Home
- [x] About
- [x] Contact
- [x] Privacy
- [x] Terms and Conditions

### Authentication
- [x] Sign In
- [x] Log Out
- [x] Sign Up
- [ ] Forgot Password
- [ ] Change Password
- [ ] Confirm Email

### Dashboard
- [ ] Profile
- [x] Lists
- [ ] List

### Functions
- [ ] Form Validation.
- [ ] Oauth2(Facebook, Google, Twitter, Github, etc login).

## Build

**Step 1**: Download this repository or git clone it. 
**Step 2**: Open your command line and run 'cd' into the project. 
**Step 3**: Run 'composer install' to download the PHP dependencies.
**Step 4**: Run 'npm install' to download the node_modules black hole (front end dependencies).
**Step 5**: Now run npm start to compile all of the assets into public/build.
**Step 6**: Start a server, and your good to go.

### Step 1: Run NPM and Composer


### Step 2: Build the assets
 Our assets are contained within the root level /assets folder. This folder contains all of our .scss and .js files, waiting to be built into /public/build. The assets work through a simple templating system.
 
 - There are only 3 entries called for by webpack. One entry for each section. front.js, auth.js, and dash.js.
 - These javascript files will require every dependency required for its section of the site. IE: front.js contains all frontend dependencies.
 - All three javascript files require the central base.js file. This contains all of the sitewide dependencies.
 - Custom javascript is written within the scripts files located in /front/scripts.front.js, /auth/scripts.auth.js, etc. 
 - Each entry requires it's own respective .scss file. IE: front.js requires front.scss.
 - These .scss files utilize the same templating idea.
 
 ### Webpack Entries
 1. front.js (Becomes front.js, and front.css).
 2. auth.js (Becomes auth.js, and auth.css) 
 3. dash.js (Becomes dash.js, and dash.css) 

 ### JS Files
 - base.js (Sitewide dependencies; required by front/auth/dash/.js)
 - scripts.js (Sitewide custom js; required by base.js)
 
 - front.js (Front end dependencies; directly called on in webpack config)
 - auth.js (Auth dependencies; directly called on in webpack config)
 - dash.js (Dash dependencies; directly called on in webpack config)
 
 - /front/scripts.front.js (Front end custom js; required by front.js)
 - /auth/scripts.auth.js (Auth custom js; required by auth.js)
 - /dash/scripts.dash.js (Dash custom js; required by dash.js)
 
 
 ### CSS Files
  - base.scss (Sitewide css dependencies; required by front/auth/dash/.scss)
  - styles.scss (Sitewide custom css; required by base.scss)
  
  - front.scss (Front end css dependencies; required by front.js)
  - auth.scss (Auth css dependencies; required by auth.js)
  - dash.scss (Dash css dependencies; required by dash.js)
  
  - /front/styles.front.js (Front end custom css; required by front.scss)
  - /auth/styles.auth.js (Auth custom css; required by auth.scss)
  - /dash/styles.dash.js (Dash custom css; required by dash.scss)
  
  
  ### Results
  This results in just 6 files. Each section gets one css file, and one js file. These files contain just what they need. Nothing more. Nothing less. The beauty of bundling.
  
  - front.css
  - front.js
  
  - auth.css
  - auth.js
  
  - dash.css
  - dash.js
