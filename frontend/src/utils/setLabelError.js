export const setLabelError         = (id = "", error = false, text = "") => {
    const element           = document.querySelector(id.includes("#") ? id : `#${id} + label`);
    (text !== "") && (element.innerHTML = text);
    !error ? element.classList.add("hidden") : element.classList.remove("hidden");
};