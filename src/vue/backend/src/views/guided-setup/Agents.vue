<template>
    <GuidedSetupContentCard
        :cardTitle="cardTitle"
        :steps="guidedSetupSteps"
        @back-step="goBackStep"
        @skip-step="goSkipStep"
        @continue="enablePlugin">
        <template v-slot:description>
            <p>
                Quickly build a team page with IMPress Agents,
                a full employee directory ideal for Real Estate
                teams and offices.
            </p>
        </template>
        <template v-slot:controls>
            <idx-block className="form-content">
                <idx-form-group>
                    <idx-block className="form-content__toggle">
                        {{ activateLabel }}
                        <idx-toggle-slider
                            uncheckedState="No"
                            checkedState="Yes"
                            @toggle="formUpdate({ key: 'enabled', value: !localStateValues.enabled })"
                            :active="localStateValues.enabled"
                            :disabled="formDisabled"
                            :label="activateLabel"
                        ></idx-toggle-slider>
                    </idx-block>
                </idx-form-group>
                <idx-block v-if="showError" className="form-content__error">
                    We're experiencing a problem, please try again.
                </idx-block>
            </idx-block>
        </template>
    </GuidedSetupContentCard>
</template>

<script>
import { PRODUCT_REFS } from '@/data/productTerms'
import { mapState, mapActions } from 'vuex'
import guidedSetupMixin from '@/mixins/guidedSetup'
import pageGuard from '@/mixins/pageGuard'
import GuidedSetupContentCard from '@/templates/GuidedSetupContentCard.vue'
export default {
    inject: [PRODUCT_REFS.agentSettings.repo],
    name: 'guided-setup-agents',
    mixins: [
        guidedSetupMixin,
        pageGuard
    ],
    components: {
        GuidedSetupContentCard
    },
    data () {
        return {
            formDisabled: false,
            showError: false
        }
    },
    computed: {
        ...mapState({
            guidedSetupSteps: state => state.guidedSetup.guidedSetupSteps,
            restrictedByBeta: state => state.socialPro.restrictedByBeta,
            optedInBeta: state => state.socialPro.optedInBeta
        }),
        continuePath () {
            return this.localStateValues.enabled ? '/guided-setup/agents/configure' : this.skipPath
        },
        skipPath () {
            if ((this.restrictedByBeta && this.optedInBeta) || !this.restrictedByBeta) {
                // Old Path: /guided-setup/social-pro
                return '/guided-setup/confirmation'
            } else {
                return '/guided-setup/confirmation'
            }
        }
    },
    methods: {
        ...mapActions({
            progressStepperUpdate: 'guidedSetup/progressStepperUpdate'
        }),
        async enablePlugin () {
            this.showError = false
            this.formDisabled = true
            if (this.formIsUpdated) {
                const { status } = await this.agentSettingsRepository.post({ enabled: this.localStateValues.enabled }, 'enable')
                this.formDisabled = false
                if (status === 204) {
                    this.saveAction()
                    this.$router.push({ path: this.continuePath })
                } else {
                    this.formChanges = {}
                    this.showError = true
                }
            } else {
                this.$router.push({ path: this.continuePath })
            }
        }
    },
    created () {
        this.module = 'agentSettings'
        this.cardTitle = 'Enable IMPress Agents'
        this.activateLabel = 'Enable'
    },
    mounted () {
        this.progressStepperUpdate([4, 5, 1, 0])
    }
}
</script>

<style lang="scss">
@import '~@idxbrokerllc/idxstrap/dist/styles/components/toggleSlider.scss';
@import '@/styles/formContentStyles.scss';
.list-featured {
    column-count: 2;
    font-weight: 700;
    list-style-type: circle;
    padding-left: 1.125em;
}
</style>
