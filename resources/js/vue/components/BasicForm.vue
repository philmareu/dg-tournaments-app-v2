<template>
    <form class="uk-form uk-form-stacked" @submit.prevent="submit($event)">
        <slot></slot>

        <div v-if="status.errors != null" class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" @click.prevent="closeAlert('errors')" uk-close></a>
            <p v-text="status.errors"></p>
        </div>
        <div v-if="status.success != null" class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" @click.prevent="closeAlert('success')" uk-close></a>
            <p v-text="status.success"></p>
        </div>

        <div class="uk-text-right">
            <div v-if="status.thinking !== true" class="uk-text-right">
                <button class="uk-button uk-button-primary uk-button-small" type="submit" v-html="buttons.save.html"></button>
            </div>
            <div v-show="status.thinking" class="uk-flex uk-flex-center">
                <div uk-spinner></div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['buttons', 'thinking', 'status'],
        methods: {
            submit(event) {
                var form = $(event.target);
                this.$emit('submitted', form, form.serialize());
            },
            closeAlert: function(type) {
                if(type === 'errors') this.status.errors = null;
                if(type === 'success') this.status.success = null;
            }
        }
    }
</script>