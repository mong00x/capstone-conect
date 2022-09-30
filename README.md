## This is the Repo of the HIT401 Web App
This is a web app that allows students to pick their projects for HIT401 Capstone Project, and for supervisors to manage their projects and students' requests. The project is built using React + PHP.
### Installation and setup
#### 1. Client Side
Clone down this repository. You will need `node` and `npm` installed globally on your machine.

Navigate to the `client` directory

Then intall the dependencies:
```bash
npm install
```
To Run the client:
```bash
npm run dev
```
The client is now running locally on port `5173`, open your browser and navigate to `localhost:5173` to access it.

#### 2. Server side
To run the server, you will need `PHP` and `XAMPP` installed on your machine. 

Start XAMPP, config the Apache server by opening "config" and select "Apache(httpd.conf)". Navigate to line 253 and edit drectory 
```bash
<Directory [server directory]>
```
Then, save and restart the Apache server.

Then in XAMPP, start the MySQL database and create the test database by executing file "hit401.sql"

Your test server should be running on https://localhost

Refresh your Client site and now you should be able to see and manipulate your server data. 👌 


### NPM Packages used
1. UI Library: [Chakra UI](https://chakra-ui.com/)
2. State management: [React Query(server)](https://tanstack.com/query/v4/?from=reactQueryV3&original=https://react-query-v3.tanstack.com/) and [Zustand(client global)](https://github.com/pmndrs/zustand)
3. Routing: [React Router](https://reactrouter.com/en/main)
4. Data fetching: [Axios](https://axios-http.com/docs/intro)
5. Drag and Drop: [React DnD](https://react-dnd.github.io/react-dnd/)

