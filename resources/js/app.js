import "./bootstrap";

import Alpine from "alpinejs";
import * as FloatingUI from "@floating-ui/dom";
import axios from "axios";
import collapse from "@alpinejs/collapse";
import { config } from "daisyui";

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
            cities: cities.data,
            districts: districts.data,
        };
    },
    async getData() {
        this.regions = await this.fetchData("regions");
        this.cities = await this.fetchData("cities");
        this.districts = await this.fetchData("districts");
    },
    async fillSelectionCityByRegion(e) {
        const regionName = e.target.value;

        const region = this.regions.find((item) => item.name === regionName);

        const data = await this.fetchByRegion(region.code);
        console.log(data);
        this.cities = [...data.cities];
        this.districts = [...data.districts];
    },
    async fillSelectionBarangayByCity(e) {
        const cityName = e.target.value;

        const city = this.cities.find((item) => item.name === cityName);

        const _barangays = await axios.get(
            `https://psgc.gitlab.io/api/cities/${city.code}/barangays/`
        );
        this.barangays = [..._barangays.data];
    },
}));

Alpine.data("result", () => ({
    toggle: false,
    description: null,
    cleanupUI: null,

    init() {
        const button = document.getElementById("result-mail-modal-trigger");
        const tooltip = document.getElementById("result-mail-modal");

        this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip, () =>
            this.spawnModal(button, tooltip)
        );

        this.$watch("toggle", () => {
            this.spawnModal(button, tooltip);
        });
    },

    spawnModal(button, tooltip) {
        const { computePosition, autoPlacement } = window.FloatingUI;

        computePosition(button, tooltip, {
            placement: "bottom-end",
            // middleware: [
            //     autoPlacement()
            // ],
        }).then(({ x, y }) => {
            Object.assign(tooltip.style, {
                left: `${x}px`,
                top: `${y}px`,
            });
        });
    },

    openToggle() {
        this.toggle = !this.toggle;
    },

    quillEditor() {
        const editor = document.getElementById("editor");
        const quill = new Quill(editor, {
            theme: "snow",
        });
    },

    content() {
        const desription = document
            .getElementById("editor")
            .querySelector(".ql-editor").innerHTML;
        this.description = desription;
    },
}));

Alpine.data("payment", () => ({
    toggle: false,
    description: null,
    cleanupUI: null,

    init() {
        const button = document.getElementById("payment-modal-trigger");
        const tooltip = document.getElementById("payment-modal");

        this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip, () =>
            this.spawnModal(button, tooltip)
        );

        this.$watch("toggle", () => {
            this.spawnModal(button, tooltip);
        });
    },

    spawnModal(button, tooltip) {
        const { computePosition, autoPlacement } = window.FloatingUI;

        computePosition(button, tooltip, {
            placement: "bottom-end",
            // middleware: [
            //     autoPlacement()
            // ],
        }).then(({ x, y }) => {
            Object.assign(tooltip.style, {
                left: `${x}px`,
                top: `${y}px`,
            });
        });
    },

    openToggle() {
        this.toggle = !this.toggle;
    },

    quillEditor() {
        const editor = document.getElementById("editor");
        const quill = new Quill(editor, {
            theme: "snow",
        });
    },

    content() {
        const desription = document
            .getElementById("editor")
            .querySelector(".ql-editor").innerHTML;
        this.description = desription;
    },
}));

Alpine.data("carouselCreate", () => ({
    image: null,
    fileUploadHandler(e) {
        const { files } = e.target;

        const reader = new FileReader();

        reader.onload = function () {
            this.image = reader.result;
        }.bind(this);

        reader.readAsDataURL(files[0]);
    },
}));

Alpine.data("carouselShow", () => ({
    isActive: null,
    init() {
        this.$watch("isActive", () => {
            console.log("watchers");
            if (this.isActive === null) return;
            this.updateActiveStatus();
        });
    },
    activeToggleInit(data) {
        console.log(data);
        const toggle = document.getElementById("isActiveToggle");

        if (data === 1) {
            toggle.setAttribute("checked", true);
            toggle.value = true;
        } else {
            toggle.value = false;
        }
    },
    activeToggleAction(e) {
        const data = e.target.value === "true" ? true : false;

        this.isActive = !data;
    },
    async updateActiveStatus() {
        try {
            console.log("update Function");
            const config = {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            };

            const response = await axios.get(
                `?is_active=${this.isActive}`,
                config
            );

            this.isActive = null;
        } catch (error) {
            console.log(error);
            //     window.sweetAlert.fire({
            //         title: "Something went Wrong",
            //         text: `${error.response.data.message}`,
            //         icon: "error",
            //       })
        }
    },
}));

Alpine.data("calendar", (role) => ({
    showModal: false,
    clickedDate: null,
    authRole: role,
    appointments: [],
    toggle: false,
    initializeCalendar(data) {
        var calendarEl = document.getElementById("calendar");

        console.log(this.authRole);
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            // eventClick: (info) => {
            //     this.toggle = !this.toggle
            //     console.log("hello world");
            //     this.getAppointmentByDate(this.clickedDate)
            //     // this.clickedDate = info.date;
            //     // this.showModal = true;
            //     // console.log(info);
            // },
            dateClick: function (date) {
                console.log("hello world");
                this.toggle = true;
                this.getAppointmentByDate(date.dateStr);
            }.bind(this),
            events: this.calendarEventsMapping(data)
        });
        calendar.render();
    },
    calendarEventsMapping(eventData) {
        const appointmentsPerDay = this.countEventPerDay(eventData)


        const dataEvents = Object.keys(appointmentsPerDay).map(event => ({
            title: `${appointmentsPerDay[event]} Appointment`,
            start: new Date(event),
            end: new Date(event),
            allDay: true
        }));

        console.log(dataEvents)
        return dataEvents
    },
    countEventPerDay(eventData) {
        const appointmentsPerDay = {};

        eventData.forEach(event => {
            const dateKey = new Date(event.date).toISOString().split('T')[0];

            if (appointmentsPerDay[dateKey]) {
                appointmentsPerDay[dateKey]++;
            } else {
                appointmentsPerDay[dateKey] = 1;
            }
        });

        return appointmentsPerDay;
    },
    convertEvents(eventsData) {
        return eventsData.map((event) => {
            let base_url = "#";

            if (this.authRole === "admin") {
                base_url = `/admin/appointment/${event.id}`;
            }

            return {
                title: event.patient,
                // url: base_url,
                start: new Date(event.date),
                end: new Date(event.date),
                backgroundColor:
                    event.status === "pending"
                        ? "#fbbd23"
                        : event.status === "approved"
                        ? "#04ABA3"
                        : "#f87272",
            };
        });
    },
    async getAppointmentByDate(date) {
        try {
            console.log(this.authRole === 'employee');
            let response = '';

            if(this.authRole == 'employee') {
                response = await axios.get(`/employee/appointment/date=${date}`);
                this.appointments = [...response.data.appointments];
                return
            }
            if (this.authRole !== "admin") {
              response = await axios.get(`/patient/appointment/date=${date}`);
            }
            else{
               response = await axios.get(`/admin/appointment/date=${date}`);
            }

            this.appointments = [...response.data.appointments];
        } catch (error) {
            console.log(error.response.data);
        }
    },
    timeFormat(timeData) {
        const time = new Date(timeData);

        return time.toLocaleString("en-US", {
            hour: "numeric",
            minute: "numeric",
            hour12: true,
        });
    },
}));

Alpine.data("sidebarAction", () => ({
    toggle: false,
    toggleAction() {
        this.toggle !== this.toggle;
    },
}));

Alpine.data("starRating", () => ({
    rating: 0,
    hoverRating: 0,
    ratings: [
        { amount: 1, label: "Terrible" },
        { amount: 2, label: "Bad" },
        { amount: 3, label: "Okay" },
        { amount: 4, label: "Good" },
        { amount: 5, label: "Great" },
    ],
    rate(amount) {
        console.log(amount);
        if (this.rating == amount) {
            this.rating = 0;
        } else this.rating = amount;
    },
    currentLabel() {
        let r = this.rating;
        if (this.hoverRating != this.rating) r = this.hoverRating;
        let i = this.ratings.findIndex((e) => e.amount == r);
        if (i >= 0) {
            return this.ratings[i].label;
        } else {
            return "";
        }
    },
}));

Alpine.data("printReport", () => ({
    elem: null,
    init() {
        this.elem = this.$refs.printElem;
        console.log(this.elem);
    },
    printElement() {
        const opt = {
            margin: 1,
            filename: "Sales Report",
        };

        const html2pdf = window.html2pdf().set(opt).from(this.elem).save();
    },
}));

Alpine.plugin([collapse]);

Alpine.start();
