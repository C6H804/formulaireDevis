export const addProject = async (type) => {
    const id = window.projectList[window.projectList.length - 1]?.id + 1 || 0;
    window.projectList.push({ id, type });

    const target = document.getElementById("projectsContainer");


    const idLoading = Math.random().toString(36).substr(2, 9);
    const loading = CreateElement("div", { class: "loader", id: "loading" + idLoading }, [
        CreateElement("img", { src: "/img/loader.svg", alt: "Chargement..." }),
    ]);
    target.appendChild(loading);


    const response = await fetch('components/page/formBody.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `addProject=${encodeURIComponent(JSON.stringify({ id, type }))}`,
    });
    const data = await response.text();

    document.getElementById("loading" + idLoading)?.remove();
    
    target.insertAdjacentHTML('beforeend', data);

    updateProjectIds();

    const newProject = document.getElementById('project' + id);
    if (newProject) {
        newProject.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    return id;
};

function updateProjectIds() {
    const projectIds = window.projectList.map(p => p.id).join(',');
    const element = document.getElementById('projectIds');
    if (element) {
        element.value = projectIds;
        changeProjectDisplay();
    } else {
        console.error('Élément projectIds introuvable !');
    }
}
