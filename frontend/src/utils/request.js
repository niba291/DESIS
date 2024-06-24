export const request        = async (url, body) => {
    body                    = {        
        method              : "GET",
        headers             : {
            "Content-Type"  : "application/json",
        },
        ...body
    }
    const response          = await fetch(url, body);
    return response.json();
};