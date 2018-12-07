<template>
    <div ref="popover" class="popover">
        <div class="popover-arrow"></div>
        <div class="popover-content">
            <slot>
                Default content
            </slot>
        </div>
    </div>
</template>

<script>
import Popper from 'popper.js';

export default {
    props: {
        name: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            visible: false,
            popper: null
        };
    },

    methods: {
        close () {
            if (!this.visible) {
                return;
            }

            this.visible = false;
        },

        open () {
            if (this.visible) {
                return;
            }

            this.visible = true;

            this.$nextTick(() => {
                this.setupPopper();
            });
        },

        setupPopper () {
            if (this.popper === null) {
                this.popper = new Popper(this.$refs.button, this.$refs.popover, {
                    placement: 'auto'
                });
            } else {
                this.popper.scheduleUpdate();
            }
        }
    }
};
</script>

<style scoped>
.popover {
	position: absolute;
	visibility: visible;
	opacity: 1;
	transition: all .12s cubic-bezier(0.250, 0.460, 0.450, 0.940);
	transform: translateY(-8px);

	margin-top: 10px;
	border-width: 1px;
	border-style: solid;
	border-color: #888;
	border-radius: 7px;
	box-shadow: 0 3px 5px rgba(0, 0, 0, 0.15);

	padding: 1rem;
	min-width: 20rem;
	background: white;
}

.popover::before,
.popover::after {
  position: absolute;
  top: -8px; left: 16px;
  width: 0;
  height: 0;

  border-width: 8px;
  border-style: solid;
  border-color: transparent;
  border-radius: 3px;
  content: "";
}

.popover::before {
  border-top-color:  #888;
  border-left-color: #888;
  -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
          transform: rotate(45deg);
}

.popover::after {
  border-top-color:  #fff;
  border-left-color: #fff;
  -webkit-transform: rotate(45deg) translate(1px, 1px);
      -ms-transform: rotate(45deg) translate(1px, 1px);
          transform: rotate(45deg) translate(1px, 1px);
}
</style>
