export const addProject = async (type) => {
    const id = window.projectList[window.projectList.length - 1]?.id + 1 || 0;
    window.projectList.push({ id, type });
    const target = document.getElementById("projectsContainer");
    
    const response = await fetch('components/page/formBody.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `addProject=${encodeURIComponent(JSON.stringify({ id, type }))}`,
    });
    const data = await response.text();
    
    target.insertAdjacentHTML('beforeend', data);

    updateProjectIds();
    return id;
};

function updateProjectIds() {
    const projectIds = window.projectList.map(p => p.id).join(',');
    const element = document.getElementById('projectIds');
    if (element) {
        element.value = projectIds;
        console.log('projectIds mis à jour:', projectIds);
    } else {
        console.error('Élément projectIds introuvable !');
    }
}