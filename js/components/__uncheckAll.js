export const uncheckAll = (containerId) => {
    document.querySelectorAll(containerId + " input[type='checkbox'], " + containerId + " input[type='radio']").forEach(input => {
        input.checked = false;
    });
};