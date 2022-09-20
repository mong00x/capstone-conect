## This is the Repo of the HIT401 Web App
This is a web app that allows students to pick their projects for HIT401 Capstone Project, and for supervisors to manage their projects and students' requests. The project is built using React + PHP.
### Installation and setup
Clone down this repository. You will need `node` and `npm` installed globally on your machine.

Navigate to the `client` directory

Then intall the dependencies:
```bash
npm install
```
To Run the app:
```bash
npm run dev
```
Projct is now running locally on port `5173`, open your browser and navigate to `localhost:5173` to access it.


### Packages used
1. UI Library: [Chakra UI](https://chakra-ui.com/)
2. State management: [React Query(server)](https://tanstack.com/query/v4/?from=reactQueryV3&original=https://react-query-v3.tanstack.com/) and [Zustand(client global)](https://github.com/pmndrs/zustand)
3. Routing: [React Router](https://reactrouter.com/en/main)

