export const changeProject = async (id = 0, type = window.projectType[0]) => {
    const response = await fetch("components/page/formBody.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `changeProject=${encodeURIComponent(JSON.stringify({ id, type }))}`,
    });

    const result = await response.text();
    return result;
};