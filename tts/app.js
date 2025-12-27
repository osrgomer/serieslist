let isGenerating = false
let logs = []

const btn = document.getElementById("generateBtn")
const logsEl = document.getElementById("logs")
const textEl = document.getElementById("text")
const voiceEl = document.getElementById("voice")
const personaEl = document.getElementById("persona")
const clearBtn = document.getElementById("clearLogs")

function addLog(msg) {
  const time = new Date().toLocaleTimeString("en-GB")
  logs.unshift(`[${time}] ${msg}`)
  logs = logs.slice(0, 15)
  logsEl.innerHTML = logs.map(l => `<div class="mb-1">${l}</div>`).join("")
}

// clear logs
clearBtn.onclick = () => {
  logs = []
  logsEl.innerHTML = "Awaiting Pipeline Input"
}

// browser TTS handler
btn.onclick = () => {
  if (isGenerating) return
  const text = textEl.value.trim()
  if (!text) return

  const voiceName = voiceEl.value
  const persona = personaEl.value

  addLog(`Speaking in a ${persona} voice: ${text}...`)
  isGenerating = true
  btn.textContent = "Speaking..."

  try {
    speechSynthesis.cancel()
    const utterance = new SpeechSynthesisUtterance(`Say in a ${persona} voice: ${text}`)

    // attempt to pick a matching voice
    const voices = speechSynthesis.getVoices()
    const selected = voices.find(v => v.name.toLowerCase().includes(voiceName.toLowerCase()))
    if (selected) utterance.voice = selected

    utterance.onend = () => {
      isGenerating = false
      btn.textContent = "Generate Voice"
      addLog("Playback finished.")
    }

    speechSynthesis.speak(utterance)
    addLog("Playback started successfully.")

  } catch (err) {
    addLog("Speech Error: " + err.message)
    isGenerating = false
    btn.textContent = "Generate Voice"
  }
}
