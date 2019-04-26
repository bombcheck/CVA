<template>
  <div class="col-md-12 menu-content">
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-8 is-offset-2">
            <horizontal-stepper :steps="demoSteps" @completed-step="completeStep"
              @active-step="isStepActive" @stepper-finished="alert"
            >
            </horizontal-stepper>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import HorizontalStepper from 'vue-stepper';

import StepOne from '@/main/campaigns/details/email'
import Details from '@/main/campaigns/details/detailsData'
export default {
  components: {
    HorizontalStepper
  },
  data(){
    return {
      demoSteps: [
        {
          icon: '',
          name: 'details',
          title: 'Details',
          subtitle: '',
          component: Details,
          completed: false
        },
        {
          icon: '',
          name: 'sms',
          title: 'SMS',
          subtitle: '',
          component: StepOne,
          completed: false
        },
        {
          icon: '',
          name: 'call',
          title: 'Call',
          subtitle: '',
          component: StepOne,
          completed: false
        },
        {
          icon: '',
          name: 'email',
          title: 'Email',
          subtitle: '',
          component: StepOne,
          completed: false
        }
      ]
    }
  },
  methods: {
    // Executed when @completed-step event is triggered
    completeStep(payload) {
      this.demoSteps.forEach((step) => {
        if (step.name == payload.name) {
          step.completed = true;
        }
      })
    },
    // Executed when @active-step event is triggered
    isStepActive(payload) {
      this.demoSteps.forEach((step) => {
        if (step.name == payload.name) {
          if(step.completed == true) {
            step.completed = false;
          }
        }
      })
    },
    // Executed when @stepper-finished event is triggered
    alert(payload) {
      alert('end')
    }
  }
}
</script>
