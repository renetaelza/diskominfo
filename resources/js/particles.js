import { tsParticles } from "tsparticles-engine";
import { loadSlim } from "tsparticles-slim";

(async () => {
  // load plugin slim ke engine
  await loadSlim(tsParticles);

  // load konfigurasi
  await tsParticles.load("tsparticles", {
    fullScreen: { enable: false },
    background: { color: "transparent" },
    particles: {
        number: { value: 40 },
        color: { value: "#60a5fa" },
        shape: { type: "circle" },
        opacity: { value: 0.2 },
        size: { value: { min: 10, max: 40 } },
        move: {
            enable: true,
            speed: 0.6,
            direction: "top",
            outModes: { default: "out" }
        }
    }
  });
})();
