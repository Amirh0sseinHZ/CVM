import Vue from 'vue'

export const getError = error => {
    const errorMessage = "API Error, please try again.";

    if (!error.response) {
        console.error(`API ${error.config.url} not found`);
        return errorMessage;
    }
    if (process.env.NODE_ENV === "development") {
        console.error(error.response.data);
        console.error(error.response.status);
        console.error(error.response.headers);
    }
    if (error.response.data && error.response.data.errors) {
        return error.response.data.errors;
    }

    return errorMessage;
};

export const notify = (text, type = "error",
                       title = "Authentication Error",
                       duration = 3000,
                       group = "auth") => {
    Vue.notify({group: group, type: type, title: title, duration: duration, text: text});
}

export const flash = error => {
    // ************************************************** //
    const getErrors = (error, key) => {
        return error[key];
    };
    const getType = obj => {
        return Object.prototype.toString.call(obj).slice(8, -1).toLowerCase();
    };
    const errorKeys = error => {
        if (!error || getType(error) === "string") {
            return null;
        }
        return Object.keys(error);
    };
    // ************************************************** //
    if (error && getType(error) === 'string') {
        notify(error);
    }
    if (error && getType(error) === 'object') {
        errorKeys(error).forEach(key => {
            getErrors(error, key).forEach(item => {
                notify(item);
            })
        })
    }
    // ************************************************** //
}
