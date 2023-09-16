import './bootstrap';

import Alpine from 'alpinejs';
import * as FloatingUI from '@floating-ui/dom';

window.Alpine = Alpine;
window.FloatingUI = FloatingUI;

Alpine.data('navbar', () => ({
    toggle: false,
    openToggle() {
        this.toggle = !this.toggle
    }
}));

Alpine.data('appointmentShow', () => ({
    reschedModal: false,
    cleanupUI: null,

    init() {
        const button = document.getElementById('resched-modal-trigger');
        const tooltip = document.getElementById('resched-modal');

        this.cleanupUI = window.FloatingUI.autoUpdate(button, tooltip,
            () => this.spawnModal(button, tooltip))

        this.$watch('reschedModal', () => {
            this.spawnModal(button, tooltip);
        });
    },

    spawnModal(button, tooltip) {
        const {
            computePosition,
            autoPlacement
        } = window.FloatingUI;

        computePosition(button, tooltip, {
            middleware: [
                autoPlacement()
            ],
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

    openReschedModal() {
        this.reschedModal = !this.reschedModal
    }
}))

Alpine.start();
