<template>
    <nav class="nav-mobile-user">
        <a
            role="button"
            class="trigger"
            @click="togglePopup"
        >
            <img src="https://api.adorable.io/avatars/114/admin@example.com.png" class="rounded-full h-8 w-8">
        </a>

        <div class="popup" :class="{ 'active': isOpen }">
            <div class="popup-container">
                <a
                    role="button"
                    class="popup-close"
                    @click="togglePopup"
                >
                    <app-icon name="close"></app-icon>
                </a>

                <transition-group tag="div" class="tab-content">
                    <component :is="activeSection.component" :key="activeSection.key"></component>
                </transition-group>

                <div class="tab-bar">
                    <a
                        v-for="section in availableSections"
                        :key="section.key"
                        role="button"
                        class="tab-bar-item"
                        :class="{ 'active': isActiveSection(section) }"
                        @click="switchToSection(section)"
                    >
                        <app-icon :name="section.icon"></app-icon>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import SectionDefinitions from './section-definitions';

export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            activeSection: SectionDefinitions[0],
            availableSections: SectionDefinitions,
            isOpen: false
        };
    },

    methods: {
        isActiveSection (section) {
            return this.activeSection.key === section.key;
        },

        switchToSection (section) {
            this.activeSection = section;
        },

        togglePopup () {
            this.isOpen = !this.isOpen;
        }
    }
};
</script>
