<template>
    <div class="control-blockgh">
  
      <div class="d-flex gap-2 w-100">
  
        <!-- Year -->
        <ion-select
          v-model="selectedYear"
          interface="popover"
          :interface-options="popoverOptions"
        >
        
          <ion-select-option
            v-for="year in years"
            :key="year"
            :value="year"
          >
            {{ year }}
          </ion-select-option>
        </ion-select>
  
  
        <!-- Month -->
        <ion-select
          v-model="selectedMonth"
          placeholder="Month"
          interface="popover"
          :interface-options="popoverOptions"
        >
          <ion-select-option
            v-for="month in months"
            :key="month.value"
            :value="month.value"
          >
            {{ month.name }}
          </ion-select-option>
        </ion-select>
  
  
        <!-- Day -->
        <ion-select
          v-model="selectedDay"
          placeholder="Day"
          interface="popover"
          :interface-options="popoverOptions"
        >
          <ion-select-option
            v-for="day in days"
            :key="day"
            :value="day"
          >
            {{ day }}
          </ion-select-option>
        </ion-select>
  
      </div>
  
    </div>
  </template>
  
  
  <script setup lang="ts">
  import { ref, computed, watch } from 'vue'
  import {
    IonSelect,
    IonSelectOption
  } from '@ionic/vue'
  
  
  const props = defineProps<{
    modelValue:string
    label?:string
    maxYear?:number
    minYear?:number
  }>()
  
  
  const emit = defineEmits<{
    (
      e:'update:modelValue',
      value:string
    ):void
  }>()
  
  
  const popoverOptions = {
    cssClass:'fit-content-popover'
  }
  
  
  const selectedDay = ref<number|null>(null)
  const selectedMonth = ref<number|null>(null)
  const selectedYear = ref<number|null>(null)
  
  
  const months = [
    {name:'January',value:1},
    {name:'February',value:2},
    {name:'March',value:3},
    {name:'April',value:4},
    {name:'May',value:5},
    {name:'June',value:6},
    {name:'July',value:7},
    {name:'August',value:8},
    {name:'September',value:9},
    {name:'October',value:10},
    {name:'November',value:11},
    {name:'December',value:12}
  ]
  
  
  const currentYear = new Date().getFullYear()
  selectedYear.value = currentYear
  
  
  const years = computed(()=>{
  
    const start =
      props.maxYear ?? currentYear
  
    const end =
      props.minYear ?? start - 100
  
  
    return Array.from(
      {
        length:start - end + 1
      },
      (_,i)=>start - i
    )
  
  })
  
  
  const days = computed(()=>{
  
    if(
      !selectedMonth.value ||
      !selectedYear.value
    ){
  
      return Array.from(
        {
          length:31
        },
        (_,i)=>i + 1
      )
  
    }
  
  
    const totalDays = new Date(
      selectedYear.value,
      selectedMonth.value,
      0
    ).getDate()
  
  
    return Array.from(
      {
        length:totalDays
      },
      (_,i)=>i + 1
    )
  
  })
  
  
  // Remove invalid day when month/year changes
  watch(
    [
      selectedMonth,
      selectedYear
    ],
    ()=>{
  
      if(
        selectedDay.value &&
        !days.value.includes(selectedDay.value)
      ){
  
        selectedDay.value = 1
  
      }
  
    }
  )
  
  
  // Emit only valid dates
  watch(
    [
      selectedDay,
      selectedMonth,
      selectedYear
    ],
    ()=>{
  
      if(
        !selectedDay.value ||
        !selectedMonth.value ||
        !selectedYear.value
      ){
  
        return
  
      }
  
  
      const daysInMonth = new Date(
        selectedYear.value,
        selectedMonth.value,
        0
      ).getDate()
  
  
      if(selectedDay.value > daysInMonth){
        selectedDay.value = 2
      }
  
  
      emit(
        'update:modelValue',
        `${selectedYear.value}-${String(selectedMonth.value).padStart(2,'0')}-${String(selectedDay.value).padStart(2,'0')}`
      )
  
    }
  )
  
  
  // Load existing date when editing
  watch(
    ()=>props.modelValue,
    value=>{
  
      if(!value){
        return
      }
  
  
      const [
        year,
        month,
        day
      ] = value.split('-')
  
  
      selectedYear.value = Number(year)
      selectedMonth.value = Number(month)
      selectedDay.value = Number(day)
  
    },
    {
      immediate:true
    }
  )
  
  </script>
  
  <style>
  
  .fit-content-popover {
    --width:fit-content;
  }
  
  </style>