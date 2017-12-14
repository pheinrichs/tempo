export default class Form {
    constructor(data) {
        this.methods = ['post', 'get', 'patch', 'delete'];
        this.errors = null; // new Errors();

        this.init(data);

    }

    init(data) {
        this.originalData = data;
        for (let field in data) {
            this[field] = data[field];
        }
    }

    data() {
        let data = Object.assign({}, this);
        delete data.originalData;
        delete data.errors;
        return data;
    }

    errors() {
        return this.errors;
    }

    reset() {
        for (let field in this.originalData) {
            switch (typeof (this[field])) {
                case 'string':
                    this[field] = '';
                case 'boolean':
                    this[field] = false;
                default:
                    this[field] = '';
            }
        }
    }

    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            let request = null;
            request = this.methods.find(method => method == requestType);
            if (request == null) throw "Invalid expression passed";

            axios[requestType](url, this.data())
                .then(response => {
                    this.reset();
                    resolve(response.data.data);
                })
                .catch(this.onFail.bind(this))
        });
    }

    onFail(error) {
        this.errors = error.response.data.errors
    }
}