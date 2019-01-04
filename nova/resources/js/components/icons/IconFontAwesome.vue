<script>
import BaseIcon from './BaseIcon.vue';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { library, dom } from '@fortawesome/fontawesome-svg-core';

export default {
    name: 'IconFontAwesome',

    extends: BaseIcon,

    computed: {
        iconClasses () {
            const iconClasses = {
                'icon': true,
                'fa-fw': true
            };

            iconClasses[this.iconName] = true;

            return iconClasses;
        }
    },

    mounted () {
        library.add(fas, far);

        dom.watch();
    }
};
</script>