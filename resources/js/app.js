require('./bootstrap');

class Api {
    get base() {
        return '/api/'
    }

    prepareData = (data) => {
        if (data) {
            switch (typeof data) {
                case "object":
                    if(Array.isArray(data)) {
                        return data.map((item, index) => `data[${index}]=${item}`).join('&')
                    } else {
                        let res = '';
                        for(let s of Object.entries(data)) {
                            res += `${s[0]}=${s[1]}`
                        }
                        return res
                    }
                default:
                    return `data=${data}`
            }
        }

        return data
    }

    get(method, data = null) {
        return fetch(this.base + method + (this.prepareData(data) ?? ''), {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json'
            },
            referrerPolicy: 'no-referrer'
        }).then(response => response.json())
    }

    post(method, data) {
        return fetch(this.base + method, {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json'
            },
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        }).then(response => response.json())
    }

    serializeObject(el) {
        let obj = {};
        const arr = el.serializeArray();

        arr.forEach((item) => {obj[item.name] = item.value})

        return obj
    }
}

window.__Api = new Api()
