import React from "react";
import ProjectCard from "./ProjectCard";
import { 
  Flex,
  // Grid,
  Spinner,
  Text
     } from "@chakra-ui/react";
import SearchFilter from "./SearchFilter";
import { searchStore } from "../../store";

import { FixedSizeList as List } from 'react-window';
import AutoSizer from "react-virtualized-auto-sizer";
import supabase from "../../api/supabaseClient";


import { useQuery } from "@tanstack/react-query";

import "./MainContent.css";

const disciplineCode = {
    6:"CYS",
    8:"IS",
    19:"SD",
    20:"NW",
    22:"AI",
    23:"DA"
}


const MainContent = () => {
  const search = searchStore((state) => state.search);
  const [projects, setProjects] = React.useState([]);
  const [disciplines, setDisciplines] = React.useState([]);
  console.log(process.env.NODE_ENV);
  // const projectUrl =
  //   process.env.NODE_ENV === "development"
  //     ? "http://localhost/all_projects.php"
  //     : "https://cduprojects.spinetail.cdu.edu.au/adminpage/all_projects.php";

  //   const mappingUrl =
  //   process.env.NODE_ENV === "development"
  //     ? "http://localhost/project_discipline.php"
  //     : "https://cduprojects.spinetail.cdu.edu.au/adminpage/project_discipline.php";

  // supabase url

  // const fetchProjects = async () => {
     // if in development mode, api url is localhost, else it is the cpanel url

  //   const { data } = await axios.get(projectUrl);
     // return data.projects.splice(0, 10);
  //   return data.projects;
     //error handling
  // };

  const fetchProjects = async () => {
    const {data} = await supabase.from('projects').select('*');
    setProjects(data);
    return data;
  }

  // const fetchMapping = async () => {
  //   // if in development mode, api url is localhost, else it is the cpanel url

  //   const { data } = await axios.get(mappingUrl);
  //   // console.log("fetchMapping", data);
  //   return data['projects discipline mapping'];
  //   //error handling
  // };

  const fetchMapping = async () => {
    const {data} = await supabase.from('discipline_project_mapping').select('*');
    setDisciplines(data);
  }


  React.useEffect (() => {
    fetchMapping();
  }, []);

  // React.useEffect(() => {
  //   if (isSuccessP & search ) {
  //     console.log("search", search);
  //     console.log("dataP", dataP);
  //     const filtered = dataP.filter((project) => {
  //       return project.project_title.toLowerCase().includes(search.toLowerCase());
  //     });
  //     console.log("filtered", filtered);
  //     setData(filtered);
  //     console.log("data", data);
  //   }else{
  //     setData(dataP);
  //   }
  // }, [search]);



  // on dataM fetched, save the result to disciplinestore

  const { isLoading:isLoadingP, isError:isErrorP, isSuccess:isSuccessP, data:dataP, error:errorP, } = useQuery(
    ["projects"],
    fetchProjects
  );

  const findDiscpline = (projectId, disciplines) => {
    var result = [];
    if (disciplines) {
      disciplines.forEach((discpline) => {
        if (discpline.project_id === projectId) {
          result.push(disciplineCode[discpline.discipline_id]); 
        }
      });
    }
    return result;
  };



  return isLoadingP ? (
    <Flex
      justifyContent="center"
      alignItems="center"
      height="100vh"
      width="100vw"
    >
      <Spinner
        thickness="4px"
        speed="0.65s"
        emptyColor="gray.200"
        color="blue.500"
        size="xl"
      />
    </Flex>
  ) : isSuccessP ? (
    <Flex flexDir="column" w="100%" h="100%" color="DarkShades" bg="ContentBG">
      <SearchFilter />
        <AutoSizer>
           {({ height, width }) => (
          <List
            className="List"
            height={height}
            itemCount={dataP.length}
            itemSize={40000/width + 280}
            width={width}

          >
         
            
            {({ index, style }) => ( 


              <div style={style} className={index % 2 ? "ListItemOdd" + " index" + index : "ListItemEven" + " index" + index}>
                {
                  search ? (
                    dataP.filter((project) => Object.values(project).join("").toLowerCase().includes(search.toLowerCase())).length !== 0  ? (
                      index < dataP.filter((project) => Object.values(project).join("").toLowerCase().includes(search.toLowerCase())).length ? (
                        <ProjectCard 
                      key={dataP.filter((project) => Object.values(project).join("").toLowerCase().includes(search.toLowerCase()))[index].project_id}
                      project={dataP.filter((project) => Object.values(project).join("").toLowerCase().includes(search.toLowerCase()))[index]}
                      disciplines={findDiscpline(dataP.filter((project) => Object.values(project).join("").toLowerCase().includes(search.toLowerCase()))[index].project_id, disciplines)}
                    />
                        
                      ):( 
                        <div style={{height: "0px"}}></div>
                      )


                    ):(console.log("no match"))


                  

                  ):(

                  <ProjectCard
                    key={dataP[index].project_id}
                    project={dataP[index]}
                    disciplines={findDiscpline(dataP[index].project_id, disciplines)}
                  />
                )
                }
                
                
                
                
                
              </div>
            )}
            

              
          </List>
          
        )}


      </AutoSizer>
      
     
      
       
      {/* <Grid *original code
    
        columnCount={1000}
        columnWidth={100}
        height={150}
        rowCount={1000}
        rowHeight={35}
        width={300}
      >
        {disciplines &&
          dataP
            .filter((project) =>
              Object.values(project)
                .join("")
                .toLowerCase()
                .includes(search.toLowerCase())
            )
            .map((project) => (
              <ProjectCard key={project.project_id} project={project}  disciplines={findDiscpline(project.project_id, disciplines)}/> // why getdisciplines(project.project_id) 
            ))}
      </Grid> */}
    </Flex>
  ) : (
    isErrorP && (
      <Flex
        justifyContent="center"
        alignItems="center"
        height="100vh"
        width="100vw"
      >
        <Text>Something went wrong</Text>
      </Flex>
    )
  );
};

export default MainContent;
