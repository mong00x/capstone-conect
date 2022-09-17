import create from "zustand";

const useStore = create((set) => ({
  projects: [
    {
      id: 1,
      number: 1,
      topic: "Machine learning approaches for Cyber Security",
      description:
        "As we use internet more, the data produced by us is enormous. But are these data being secure? The goal of applying machine learning or intelligence is to better risk modelling and prediction and for an informed decision support. Students will be working with either supervised or unsupervised machine learning approaches to solve the problem/s in the broader areas of Cyber Security.The Transportation Security Administration (TSA) has a complex security program that requires officers to visually search travelers’ baggage for prohibited objects, or cues to such objects, which may pose a threat to security. This visual search - when conducted by humans - is difficult to successfully complete as it may result in either a false positive (finding a non-threatening object) or a false negative (missing a threatening object); indeed, a recent assessment reported that TSA screeners missed 95% percent of mock explosive and banned weapons smuggled through checkpoints (ABC News, 2015). It is possible that effective screening may be achieved via the coupling of human screeners and detection technology. Here, the proposal is to design an algorithm that analyses x-ray images during baggage (and/or person) screening to automatically give an alert when a potential threat is detected. The challenge is to utilise deep neural networks to aid with image and object recognition; specifically, to detect the presence of a threat within compact, cluttered and diverse baggage content in a timely-manner, thus providing travel safety assurances.",
      keywords: [
        "Internal",
        "External",
        "Computer Science",
        "Information Systems and Data Science",
        "Software Engineering",
      ],
      supervisors: ["Dr. Bharanidharan Shanmugam", "Dr. Sami Azam"],
    },
    {
      id: 2,
      number: 2,
      topic:
        "Enhancing airport screening using a deep neural network algorithm",
      description:
        "The Transportation Security Administration (TSA) has a complex security program that requires officers to visually search travelers’ baggage for prohibited objects, or cues to such objects, which may pose a threat to security. This visual search - when conducted by humans - is difficult to successfully complete as it may result in either a false positive (finding a non-threatening object) or a false negative (missing a threatening object); indeed, a recent assessment reported that TSA screeners missed 95% percent of mock explosive and banned weapons smuggled through checkpoints (ABC News, 2015). It is possible that effective screening may be achieved via the coupling of human screeners and detection technology. Here, the proposal is to design an algorithm that analyses x-ray images during baggage (and/or person) screening to automatically give an alert when a potential threat is detected. The challenge is to utilise deep neural networks to aid with image and object recognition; specifically, to detect the presence of a threat within compact, cluttered and diverse baggage content in a timely-manner, thus providing travel safety assurances.\rPotential issues that require solutions:\r1. Utilise a machine learning framework – based on convolutional neural networks, for example - that processes images captured either by checkpoint baggage screeners or body scanners then detects threatening objects. These objects are usually intentionally obscured by other items, thus a computer algorithm that automatically identifies threat is useful in reducing the risk of misdetection during the physical inspection of the x-ray image. The detection must be rapid and accurate, potentially with a better performance rate than that of human screeners, in order to reduce the amount of work done by a human inspector.\r2. Develop an algorithm that identifies regions within the images captured either by checkpoint baggage screeners or body scanners that may include threatening objects. This alternative solution enables the human screener to then review only the alerted regions of the image, thus not only reducing the amount of time they need to scan the entire image for a potential threat, but also enabling them to focus all cognitive effort on alerted regions.\r3. Minimise the false alarm rate when detecting non-threatening objects in images captured either by checkpoint baggage screeners or body scanners. This point is pertinent as it would reduce the need for checkpoint workers to pull passengers aside for further inspection.",
      keywords: [
        "Internal",
        "External",
        "Computer Science",
        "Cyber Security",
        "Data Science",
        "Software Engineering",
      ],
      supervisors: ["Dr. Mamoun Alazab", "Dr. Shahd Al-Janabi (CHHS)"],
    },
    {
      id: 3,
      number: 4,
      topic: "Augmented Reality System on Improving Safety of Young Drivers",
      description:
        "Young drivers (L- and P-platers) are over-represented when examining car-related deaths in Australia. This over-representation may stem from young drivers’ lack of experience with searching dynamic and complex visual environments in order to detect task-relevant items, including traffic signs, pedestrians and other cars, or gauging distances between their own car and others (i.e., depth perception). Augmented-reality may serve as an effective tool that enhances the driving performance of young drivers by graphically overlaying visual information - that young drivers may miss or find difficulty calculating in their environment - onto the real world. The challenge here is, therefore, to design an augmented-reality interface that can increase the situational awareness (ability to recognise task-relevant items), and, thus, improve the decision- making (safe driving) of young drivers without increasing their cognitive or perceptual workload.\rPotential issues that require solutions:\r1. Identify the difficulties that young drivers may face whilst driving in Australia.\r2. Develop an augmented-reality head-up display that would help resolve the difficulties.\r3.Improve the usability of the augmented-reality platform by making it multi-sensory (visual and auditory display).",
      keywords: [
        "Internal",
        "External",
        "Computer Science",
        "Cyber Security",
        "Data Science",
        "Software Engineering",
      ],
      supervisors: ["Dr. Mamoun Alazab", "Dr. Shahd Al-Janabi (CHHS)"],
    },
    {
      id: 4,
      number: 8,
      topic:
        "A data science approach in analysing a complex social-environmental system (CS, SE, IS)",
      description:
        "Data science has emerged as a potential area of study in extracting the insights from a complex data and support decision-making. Today data science approaches using machine learning has been used in various sectors including eCommerce and marketing, smart cities, logistics and transport, and health and well-being. There is yet limited understanding about the application of data science for an interdisciplinary problem analysis in the real world.  For instance, there has been a little information available about the application of data science approaches in analysis of the environment systems and support decision-making for sustainable management of the natural resources. The natural environment has been changing rapidly driven by a wide range of social, economic and institutional factors at the local and global level. Climate changes has further affected all sectors including forest, agriculture and water resources that supports the life and livelihoods of humans worldwide. In capturing these environmental changes, complex process and impacts, researchers from different disciplines including forestry, agriculture, hydrology, economics etc. are collecting a rich-data today. However, due to the complexity of the environmental problems, this is a great challenge to unpack the data for a greater meaning and find solutions. Given this context, a research is proposed “to examine the role of a data science approach in explaining the complex social-environmental system”. \rThe study will answer three questions: 1) what are the most common environmental data available for analysis by data science approach? and 2) to what extent a data science approach can reveal a forest-human relationship using a large dataset from a global study? 3) what are the challenges for using a data science approach in social-environmental system analysis?",
      keywords: [
        "Internal",
        "External",
        "Computer Science",
        "Information Systems and Data Science",
        "Software Engineering",
      ],
      supervisors: ["Dr. Sami Azam", "Dr. Ronju Ahammad"],
    },
    {
      id: 5,
      number: 9,
      topic: "Informetrics applications in multidisciplinary domain",
      description:
        "Informetrics studies are concerned with the quantitative aspects of information. The applications of advanced machine learning, information retrieval, network science and bibliometric techniques on various information artefact have contributed fresh insights into the evolutionary nature of research fields. This project aims at discovering informetric properties of multidisciplinary research literature using various machine learning, network analysis, data visualisation and data wrangling tools.",
      keywords: [
        "Internal",
        "External",
        "Computer Science",
        "Cyber Security",
        "Information Systems and Data Science",
        "Software Engineering",
      ],
      supervisors: ["Dr. Yakub Sebastian ", "Dr. Bharanidharan Shanmugam"],
    },
    {
      id: 6,
      topic: "Big Data Analytics for Cybersecurity",
      description:
        "There is an exponential increase in the type and frequency of cyber-attacks in recent years. The Big Data era is making it worse as traditional methods to prevent cyber-attacks are not able to cope with these attacks. The application of Big Data Analytics techniques can possibly help in cybersecurity. Big Data Analytics can be used to monitor real-time network streams and real-time detection of both malicious and suspicious activities. The purpose of this research is to investigate the feasibility and challenges of using data analytics for cybersecurity.",
      keywords: ["Internal", "External", "Cyber Security", "Data Science"],
      supervisors: ["Dr. Charles Yeo ", "Dr. Bharanidharan Shanmugam"],
    },
  ],
  Rank: [],
  // addRank function will add selcted project topic and supervisor to Rank array
  addRank: (id, topic, supervisors) =>
    set((state) => ({
      Rank: [
        ...state.Rank,
        { id, topic, supervisors, rank: state.Rank.length + 1 },
      ],
    })),
  removeRank: (id) =>
    set((state) => ({ Rank: state.Rank.filter((i) => i.id !== id) })),
}));

export default useStore;
