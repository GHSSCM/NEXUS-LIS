<template>

  
</template>
<!-- <template>
  <div
    class="tooltip-container"
    ref="container"
    @mouseenter="handleMouseEnter"
    @mouseleave="handleMouseLeave"
  >
    <slot></slot>
    <transition name="fade">
      <div v-if="isVisible" class="tooltip" :style="tooltipStyle">
        <div class="tooltip-content" v-html="tooltipHtml"></div>
        <div class="tooltip-arrow"></div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  tooltipHtml: {
    type: String,
    required: true,
  },
})

const isVisible = ref(true)
const tooltipStyle = ref({})
const container = ref(null)

function handleMouseEnter() {
  isVisible.value = true
  updateTooltipPosition()
  window.addEventListener('scroll', updateTooltipPosition)
  window.addEventListener('resize', updateTooltipPosition)
}

function handleMouseLeave() {
  isVisible.value = false
  window.removeEventListener('scroll', updateTooltipPosition)
  window.removeEventListener('resize', updateTooltipPosition)
}

function updateTooltipPosition() {
  if (!container.value) return
  const rect = container.value.getBoundingClientRect()
  const tooltipWidth = 300 // Adjust as needed
  const tooltipHeight = 150 // Adjust as needed or let content determine height
  
  // Position the tooltip above the element with a gap of 10px.
  let top = rect.top + window.scrollY - tooltipHeight - 10
  let left = rect.left + window.scrollX + rect.width / 2 - tooltipWidth / 2

  // Ensure tooltip does not overflow the viewport.
  if (left < 10) left = 10
  if (left + tooltipWidth > window.innerWidth - 10) {
    left = window.innerWidth - tooltipWidth - 10
  }

  tooltipStyle.value = {
    position: 'absolute',
    top: `${top}px`,
    left: `${left}px`,
    width: `${tooltipWidth}px`,
  }
}
</script>

<style scoped>
.tooltip-container {
  position: relative;
  display: inline-block;
}

/* Tooltip base styling */
.tooltip {
  background: #fff;
  color: #333;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  z-index: 1000;
  font-size: 14px;
}

/* Tooltip arrow styling */
.tooltip-arrow {
  position: absolute;
  bottom: -10px;
  left: calc(50% - 10px);
  width: 0;
  height: 0;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-top: 10px solid #fff;
}

/* Fade transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style> -->
