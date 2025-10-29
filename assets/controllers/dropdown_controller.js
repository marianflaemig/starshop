//assets/controllers/dropdown_controller.js

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    // Define targets for elements we need to interact with
    static targets = ['button', 'list', 'option', 'nativeSelect', 'display'];

    connect() {
        // Close the dropdown if the user clicks anywhere outside of it
        document.addEventListener('click', this.closeOnOutsideClick.bind(this));
    }

    disconnect() {
        document.removeEventListener('click', this.closeOnOutsideClick.bind(this));
    }

    closeOnOutsideClick(event) {
        if (!this.element.contains(event.target)) {
            this.listTarget.classList.add('hidden');
        }
    }

    // Action to toggle the dropdown list visibility
    toggle(event) {
        event.preventDefault();
        this.listTarget.classList.toggle('hidden');

    }

    // Action fired when a custom option is clicked
    select(event) {
        // Get the value from the custom option (li element)
        const selectedValue = event.currentTarget.dataset.value;
        const selectedText = event.currentTarget.textContent.trim();

        // Update the hidden native <select> value (for form submission)
        this.nativeSelectTarget.value = selectedValue;
        // Update the visible display text
        this.displayTarget.textContent = selectedText;
        // Hide the dropdown list
        this.listTarget.classList.add('hidden');
    }
}
