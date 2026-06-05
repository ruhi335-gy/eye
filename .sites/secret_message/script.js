let sentences = [];
    let index = 0;

    async function init() {
      try {
        const response = await fetch('sentences.json');
        const data = await response.json();
        sentences = data.texts;
        if (sentences.length > 0) {
          writeText();
        }
      } catch (error) {
        console.error("Error loading sentences:", error);
      }
    }

    function writeText() {
      const textSpan = document.getElementById("text");
      if (!textSpan) return;

      if (index >= sentences.length) {
        index = 0;
      }

      const text = sentences[index];
      let i = 0;

      function type() {
        if (i < text.length) {
          textSpan.textContent += text.charAt(i);
          i++;
          setTimeout(type, 80);
        } else {
          setTimeout(eraseText, 1800);
        }
      }

      function eraseText() {
        if (i >= 0) {
          textSpan.textContent = text.substring(0, i);
          i--;
          setTimeout(eraseText, 20);
        } else {
          index++;
          setTimeout(writeText, 600);
        }
      }

      type();
    }

    init();