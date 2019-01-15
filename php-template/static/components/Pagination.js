





class Pagination extends HTMLElement {
    constructor() {

    }

    pager() {

    }

    pagerItem(cont) {
        return `
            <li>
                ${cont}
            </li>
        `
    }
}

customElements.define('Pagination', Pagination)