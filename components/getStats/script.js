const initDb = "USE acportaisx664385;\n";
const dataStats = [
    {
        id: 1,
        name: "produits par devis",
        preRequest: "SELECT projects_types.name, COUNT(stats_projects.id_project_Type) AS nombre_devis FROM projects_types LEFT JOIN stats_projects ON projects_types.id = stats_projects.id_project_Type LEFT JOIN stats_devis ON stats_projects.id_devis = stats_devis.id WHERE TRUE ",
        postRequest: "GROUP BY projects_types.name HAVING nombre_devis > 0 ORDER BY nombre_devis DESC;"
    },
    {
        id: 2,
        name: "sondage par devis",
        preRequest: "SELECT sondage_types.name, COUNT(stats_sondage.id_sondage_Type) AS nombre_devis FROM sondage_types JOIN stats_sondage ON sondage_types.id = stats_sondage.id_sondage_Type JOIN stats_devis ON stats_sondage.id_devis = stats_devis.id WHERE TRUE ",
        postRequest: "GROUP BY sondage_types.name HAVING nombre_devis > 0 ORDER BY nombre_devis DESC;"
    },
    {
        id: 3,
        name: "projets par sondage",
        preRequest: "SELECT st.name AS sondage_type, COUNT(sp.id_project_Type) AS nombre_projets FROM sondage_types st LEFT JOIN stats_sondage ss ON st.id = ss.id_sondage_Type LEFT JOIN stats_projects sp ON ss.id_devis = sp.id_devis LEFT JOIN stats_devis ON ss.id_devis = stats_devis.id WHERE TRUE ",
        postRequest: "GROUP BY st.name HAVING nombre_projets > 0 ORDER BY nombre_projets DESC;"
    },
    {
        id:4,
        name: "devis et projets par sondage",
        preRequest: "SELECT st.name AS sondage_type, COUNT(DISTINCT ss.id_devis) AS nombre_devis, COUNT(sp.id_project_Type) AS nombre_projets FROM sondage_types st LEFT JOIN stats_sondage ss ON st.id = ss.id_sondage_Type LEFT JOIN stats_projects sp ON ss.id_devis = sp.id_devis LEFT JOIN stats_devis ON ss.id_devis = stats_devis.id WHERE TRUE ",
        postRequest: "GROUP BY st.name HAVING nombre_devis > 0 ORDER BY nombre_devis DESC;"
    },
    {
        id:5,
        name: "projet par sondage et type de projet",
        preRequest: "SELECT pt.name AS project_type, st.name AS sondage_type, COUNT(*) AS nombre_recurences FROM projects_types pt LEFT JOIN stats_projects sp ON pt.id = sp.id_project_Type LEFT JOIN stats_sondage ss ON sp.id_devis = ss.id_devis LEFT JOIN sondage_types st ON ss.id_sondage_Type = st.id LEFT JOIN stats_devis ON ss.id_devis = stats_devis.id WHERE TRUE ",
        postRequest: "GROUP BY pt.name, st.name HAVING nombre_recurences > 0 and sondage_type IS NOT NULL ORDER BY pt.name, nombre_recurences DESC;"
    }
];

const selectStats = document.getElementById("selectTypeStats");
dataStats.forEach(stat => {
    const option = document.createElement("option");
    option.value = stat.id;
    option.textContent = stat.name;
    selectStats.appendChild(option);
});

const getMidRequest = (dateStart, dateEnd) => {
    let result = "";
    if (dateStart) {
        result += `AND stats_devis.date >= '${dateStart}' `;
    }
    if (dateEnd) {
        result += `AND stats_devis.date <= '${dateEnd}' `;
    }
    return result;
}

const getRequest = (id) => {
    const data = dataStats.find(stat => stat.id === parseInt(id));
    if (!data) {
        return "not found";
    }
    let result = "";
    result += initDb;
    result += data.preRequest;
    result += getMidRequest(document.getElementById("startDate").value, document.getElementById("endDate").value);
    result += data.postRequest;
    return result;
}


const sendRequest = () => {
    const id = document.getElementById("selectTypeStats").value;
    const request = getRequest(id);
    navigator.clipboard.writeText(request).then(() => {
        document.getElementById("result").textContent = request;
    });
};


document.getElementById("generateRequest").addEventListener("click", sendRequest);