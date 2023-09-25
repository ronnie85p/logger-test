function AjaxForm(form, options = {}) {
    this.options = {
        onBeforeRequest: null,
        onAfterRequest: null,
        onErrorRequest: null,
        onSuccessRequest: null,
        ...options,
    };

    this.form = form;

    this._init = () => {
        this.form.addEventListener("submit", (e) => this.submitForm(e));
    };

    // Get config is prepared
    this._prepareRequestConfig = () => {
        return {
            url: this.form.getAttribute("action") || window.location.href,
            method: this.form.getAttribute("method") || "GET",
        };
    };

    this._callFunc = (key, args) => {
        if (typeof this.options[key] === "function") {
            return this.options[key].call(this, ...args);
        }
    };

    // Disabled submitter button. True or False
    this.submitterDisable = (submitter, disabled = true) => {
        submitter.disabled = disabled;
    };

    // Execution before request. Abort if return False
    this.beforeRequest = (e, config) => {
        if (this._callFunc("onBeforeRequest", [e, config]) === false) {
            return false;
        }

        this.submitterDisable(e.submitter, true);

        return true;
    };

    // Execution after request
    this.afterRequest = (e) => {
        this._callFunc("onAfterRequest", [e]);
        this.submitterDisable(e.submitter, false);
    };

    // Execution if request was success response
    this.successRequest = (response) => {
        this._callFunc("onSuccessRequest", [response]);
    };

    // Execution if request was error response
    this.errorRequest = (error) => {
        this._callFunc("onErrorRequest", [error]);
    };

    // Form try submitting
    this.submitForm = async (e) => {
        e.preventDefault();

        const config = this._prepareRequestConfig();
        if (this.beforeRequest(e, config) === false) {
            return false;
        }

        try {
            const response = await axios(config).then(
                (response) => response.data
            );

            this.successRequest(response);
        } catch (error) {
            this.errorRequest(error);
        } finally {
            this.afterRequest(e);
        }
    };

    this._init();

    return this;
}
