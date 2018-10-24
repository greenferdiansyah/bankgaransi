let handlingRouter = function(level){
    var accesibility = "";
    switch (level) {
        case "superadmin":
                    accesibility = "main#home";
            break;
        case "admin":
            accesibility = "main#home";
            break;
        case "helpdesk":
            accesibility = "main#home";
            break;
        case "users":
            accesibility = "main#page_chat_message";
            break;
        default:
            accesibility = "main#page_chat_message";
            break;
    }
    return accesibility;
}