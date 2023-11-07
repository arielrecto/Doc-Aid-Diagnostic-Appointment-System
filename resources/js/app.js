import "./bootstrap";

import Alpine from "alpinejs";
import * as FloatingUI from "@floating-ui/dom";
import axios from "axios";

window.Alpine = Alpine;
window.FloatingUI = FloatingUI;

Alpine.data("navbar", () => ({
    toggle: false,
    openToggle() {
        this.toggle = !this.toggle;
    },
}));

Alpine.data("appointmentShow", () => ({
    reschedModal: false,
    cleanupUI: null,

    init() {
        const button = document.getElementById("resched-modal-trigger");
        const tooltip = document.getElementById("resched-modal");

        this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip, () =>
            this.spawnModal(button, tooltip)
        );

        this.$watch("reschedModal", () => {
            this.spawnModal(button, tooltip);
        });
    },

    spawnModal(button, tooltip) {
        const { computePosition, autoPlacement } = window.FloatingUI;

        computePosition(button, tooltip, {
            middleware: [autoPlacement()],
        }).then(({ x, y }) => {
            Object.assign(tooltip.style, {
                left: `${x}px`,
                top: `${y}px`,
            });
        });
    },

    openReschedModal() {
        this.reschedModal = !this.reschedModal;
    },
}));

Alpine.data("phLocation", () => ({
    regions: [],
    cities: [],
    municipalities: [],
    districts: [],
    barangays: [],
    init() {
        this.getData();
    },
    async fetchData(name) {
        const response = await axios.get(`https://psgc.gitlab.io/api/${name}`);
        return response.data;
    },
    async fetchByRegion(code) {
        const cities = await axios.get(
            `https://psgc.gitlab.io/api/regions/${code}/cities/`
        );
        const districts = await axios.get(
            `https://psgc.gitlab.io/api/regions/${code}/districts/`
        );
        return {
            cities : cities.data,
            districts : districts.data
        };
    },
    async getData() {
        this.regions = await this.fetchData("regions");
        this.cities = await this.fetchData("cities");
        this.districts = await this.fetchData("districts");
    },
    async fillSelectionCityByRegion(e) {
        const regionName = e.target.value;

        const region = this.regions.find(item => item.name === regionName)

        const data = await this.fetchByRegion(region.code);
        console.log(data);
        this.cities = [...data.cities];
        this.districts = [...data.districts];
    },
    async fillSelectionBarangayByCity(e) {
        const cityName = e.target.value;

        const city = this.cities.find(item => item.name === cityName)

        const _barangays = await axios.get(`https://psgc.gitlab.io/api/cities/${city.code}/barangays/`)
        this.barangays = [..._barangays.data]
    }
}));


Alpine.data('result', () => ({
    toggle: false,
    description: null,
    cleanupUI: null,

    init() {
        const button = document.getElementById('result-mail-modal-trigger');
        const tooltip = document.getElementById('result-mail-modal');

        this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip,
            () => this.spawnModal(button, tooltip))

        this.$watch('toggle', () => {
            this.spawnModal(button, tooltip);
        });
    },

    spawnModal(button, tooltip) {
        const {
            computePosition,
            autoPlacement
        } = window.FloatingUI;

        computePosition(button, tooltip, {
            placement: 'bottom-end',
            // middleware: [
            //     autoPlacement()
            // ],
        }).then(({
            x,
            y
        }) => {
            Object.assign(tooltip.style, {
                left: `${x}px`,
                top: `${y}px`,
            });
        });
    },

    openToggle() {
        this.toggle = !this.toggle
    },

    quillEditor() {
        const editor = document.getElementById('editor');
        const quill = new Quill(editor, {
            theme: 'snow'
        })
    },

    content() {
        const desription = document.getElementById('editor').querySelector(".ql-editor").innerHTML;
        this.description = desription;
    },

}));


Alpine.data('payment', () => ({
    toggle: false,
    description: null,
    cleanupUI: null,

    init() {
        const button = document.getElementById('payment-modal-trigger');
        const tooltip = document.getElementById('payment-modal');

        this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip,
            () => this.spawnModal(button, tooltip))

        this.$watch('toggle', () => {
            this.spawnModal(button, tooltip);
        });
    },

    spawnModal(button, tooltip) {
        const {
            computePosition,
            autoPlacement
        } = window.FloatingUI;

        computePosition(button, tooltip, {
            placement: 'bottom-end',
            // middleware: [
            //     autoPlacement()
            // ],
        }).then(({
            x,
            y
        }) => {
            Object.assign(tooltip.style, {
                left: `${x}px`,
                top: `${y}px`,
            });
        });
    },

    openToggle() {
        this.toggle = !this.toggle
    },

    quillEditor() {
        const editor = document.getElementById('editor');
        const quill = new Quill(editor, {
            theme: 'snow'
        })
    },

    content() {
        const desription = document.getElementById('editor').querySelector(".ql-editor").innerHTML;
        this.description = desription;
    },

}));
Alpine.start();
