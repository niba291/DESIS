export const validatorCharacterNumber  = (text) => {
    return String(text).match(/^[a-zA-Z0-9]*$/g) === null;
};