<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PDF Viewer with Search, Scroll, Drawing & Page Select - Save Coretan</title>
    <link rel="stylesheet" href="ebook-canvas.css">
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 10px;
        user-select: none;
        background: #f0f0f0;
      }
      #toolbar {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
      }
      #search-container {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        padding: 6px 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
      }
      #search-input {
        border: none;
        outline: none;
        padding: 4px;
        font-size: 14px;
        width: 200px;
      }
      #search-results {
        font-size: 12px;
        color: #666;
        margin-left: 8px;
      }
      #pdf-container {
        max-width: 95vw;
        margin: auto;
        background: white;
        padding: 1px;
        border-radius: 6px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        overflow-y: auto;
        height: 90vh;
        scrollbar-width: none;
        -ms-overflow-style: none;
      }
      #pdf-container::-webkit-scrollbar {
        display: none;
      }
      .page-container {
        position: relative;
        margin: 20px auto;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        border-radius: 4px;
        background: #fff;
      }
      canvas.pdf-canvas {
        display: block;
        width: 100%;
        height: auto;
      }
      canvas.draw-canvas {
        position: absolute;
        top: 0;
        left: 0;
        cursor: crosshair;
        z-index: 10;
        border-radius: 4px;
      }
      canvas.highlight-canvas {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 5;
        pointer-events: none;
        border-radius: 4px;
      }
      label {
        font-size: 14px;
      }
      input[type='range'] {
        vertical-align: middle;
      }
      button {
        cursor: pointer;
        padding: 6px 12px;
        font-size: 14px;
      }
      #page-selector {
        display: flex;
        align-items: center;
        gap: 8px;
      }
      #page-select {
        font-size: 14px;
        padding: 3px 6px;
      }
      .search-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 6px 8px;
        border-radius: 3px;
        cursor: pointer;
      }
      .search-btn:hover {
        background: #0056b3;
      }
      .search-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
      }
    </style>
  </head>
  <body>
    <div id="toolbar">
      <div id="search-container">
        <input type="text" id="search-input" placeholder="Cari teks dalam PDF..." />
        <button class="search-btn" id="search-btn">Cari</button>
        <button class="search-btn" id="prev-result">←</button>
        <button class="search-btn" id="next-result">→</button>
        <button class="search-btn" id="clear-search">Clear</button>
        <span id="search-results"></span>
      </div>
      <button id="draw-toggle">
        <img src="img/no-pencil.png" alt="Draw ON" style="height: 20px; vertical-align: middle" />
      </button>

      <label><input type="color" id="color-picker" value="#ff0000" /></label>
      <label><input type="range" id="brush-size" min="1" max="30" value="5" /></label>
      <button id="eraser-toggle">
        <img src="img/no-eraser.png" alt="" style="height: 20px; vertical-align: middle" />
      </button>
      <label><input type="range" id="eraser-size" min="5" max="50" value="20" /></label>
      <div id="page-selector">
        <label for="page-select">Pages</label>
        <select id="page-select"></select>
        <button id="go-to-page">submit</button>
      </div>
      <button id="clear-canvas-btn">Clear</button>
      <button id="save-canvas-btn">Save</button>
    </div>
    <div id="pdf-container"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.min.js"></script>
    <script>
      const url = 'https://mirror.alazka.id/testing/{{ $file_pdf }}';
      const pdfjsLib = window['pdfjs-dist/build/pdf'];
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.worker.min.js';

      // DOM elements
      const pdfContainer = document.getElementById('pdf-container');
      const drawToggleBtn = document.getElementById('draw-toggle');
      const eraserToggleBtn = document.getElementById('eraser-toggle');
      const colorPicker = document.getElementById('color-picker');
      const brushSizeInput = document.getElementById('brush-size');
      const eraserSizeInput = document.getElementById('eraser-size');
      const pageSelect = document.getElementById('page-select');
      const goToPageBtn = document.getElementById('go-to-page');

      // Search elements
      const searchInput = document.getElementById('search-input');
      const searchBtn = document.getElementById('search-btn');
      const prevResultBtn = document.getElementById('prev-result');
      const nextResultBtn = document.getElementById('next-result');
      const clearSearchBtn = document.getElementById('clear-search');
      const searchResults = document.getElementById('search-results');

      // Buttons for save and clear canvas
      const clearCanvasBtn = document.getElementById('clear-canvas-btn');
      const saveCanvasBtn = document.getElementById('save-canvas-btn');

      // Variables
      let pdfDoc = null;
      const drawDataPerPage = {};
      let drawMode = false;
      let eraserMode = false;
      let brushColor = colorPicker.value;
      let brushSize = parseInt(brushSizeInput.value);
      let eraserSize = parseInt(eraserSizeInput.value);
      const pagesCanvases = {};

      // Search variables
      let searchMatches = [];
      let currentMatchIndex = -1;
      const highlightCanvases = {};

      // Load saved drawings from server and call callback after done
      function loadSavedDrawings(callback) {
        fetch('/drawings/{{ $file_pdf }}')
          .then(res => res.json())
          .then(data => {
            Object.assign(drawDataPerPage, data); // masukkan semua data ke objek global
            console.log('Loaded drawings:', data);
            if (typeof callback === 'function') {
              callback(); // panggil fungsi jika disediakan
            }
          })
          .catch(err => console.error('Load error:', err));
      }

      // Save all drawings from canvases into database as base64 images
      // Fungsi untuk cek apakah canvas kosong (tidak ada coretan)
      function isCanvasEmpty(canvas) {
        const ctx = canvas.getContext('2d');
        const pixelBuffer = new Uint32Array(
          ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
        );

        // Jika semua pixel bernilai 0 (kosong), maka canvas dianggap kosong
        return !pixelBuffer.some(color => color !== 0);
      }

      function saveDrawingsToStorage() {
        const drawings = {};

        for (const pageNum in pagesCanvases) {
          const page = pagesCanvases[pageNum];
          if (page && page.drawCanvas) {
            if (!isCanvasEmpty(page.drawCanvas)) {
              drawings[pageNum] = page.drawCanvas.toDataURL();
            } else {
              console.log(`Canvas halaman ${pageNum} kosong, tidak disimpan.`);
            }
          }
        }

        fetch('/drawings/{{ $file_pdf }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ drawings })
        })
          .then(res => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.json();
          })
          .then(data => console.log('Saved:', data))
          .catch(err => console.error('Error saving:', err));
      }


      // Render image from dataURL to canvas
      function loadDrawings(pageNum) {
        const { drawCtx, drawCanvas } = pagesCanvases[pageNum];
        drawCtx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        const dataURL = drawDataPerPage[pageNum];
        if (dataURL) {
          const img = new Image();
          img.onload = function () {
            drawCtx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
            drawCtx.drawImage(img, 0, 0, drawCanvas.width, drawCanvas.height);
          };
          img.src = dataURL;
        }
      }

      // INISIALISASI: jalankan saat halaman pertama kali dimuat
      document.addEventListener('DOMContentLoaded', () => {
        loadSavedDrawings(() => {
          // Panggil loadDrawings untuk semua halaman setelah datanya siap
          for (const pageNum in pagesCanvases) {
            loadDrawings(pageNum);
          }
        });
      });


      // Drawing setup per page
      function setupDrawCanvas(drawCanvas, pageNum) {
        const drawCtx = drawCanvas.getContext('2d');
        let drawing = false;
        let lastPos = { x: 0, y: 0 };

        drawCanvas.onmousedown = (e) => {
          if (!drawMode) return;
          drawing = true;
          lastPos = getPos(e);
        };

        drawCanvas.onmouseup = () => {
          drawing = false;
          saveDrawingsToStorage(); // auto save on finish drawing
        };

        drawCanvas.onmouseout = () => {
          drawing = false;
          saveDrawingsToStorage();
        };

        drawCanvas.onmousemove = (e) => {
          if (!drawing || !drawMode) return;
          const pos = getPos(e);
          drawCtx.lineJoin = 'round';
          drawCtx.lineCap = 'round';
          drawCtx.globalCompositeOperation = eraserMode ? 'destination-out' : 'source-over';
          drawCtx.strokeStyle = eraserMode ? 'rgba(0,0,0,1)' : brushColor;
          drawCtx.lineWidth = eraserMode ? eraserSize : brushSize;
          drawCtx.beginPath();
          drawCtx.moveTo(lastPos.x, lastPos.y);
          drawCtx.lineTo(pos.x, pos.y);
          drawCtx.stroke();
          drawCtx.closePath();
          lastPos = pos;
        };

        function getPos(evt) {
          const rect = drawCanvas.getBoundingClientRect();
          return { x: evt.clientX - rect.left, y: evt.clientY - rect.top };
        }

        pagesCanvases[pageNum] = { drawCanvas, drawCtx };
      }

      function setupHighlightCanvas(pageDiv, viewport, pageNum) {
        const highlightCanvas = document.createElement('canvas');
        highlightCanvas.className = 'highlight-canvas';
        highlightCanvas.style.width = '100%';
        highlightCanvas.style.height = '100%';
        highlightCanvas.width = viewport.width;
        highlightCanvas.height = viewport.height;
        pageDiv.appendChild(highlightCanvas);

        const highlightCtx = highlightCanvas.getContext('2d');
        highlightCanvases[pageNum] = { highlightCanvas, highlightCtx };
      }

      async function searchInPDF(query) {
        if (!query.trim()) {
          clearHighlights();
          updateSearchResults();
          return;
        }

        searchMatches = [];
        clearHighlights();

        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
          const page = await pdfDoc.getPage(pageNum);
          const textContent = await page.getTextContent();
          const viewport = page.getViewport({ scale: 1.5 });

          textContent.items.forEach((item) => {
            const text = item.str.toLowerCase();
            const searchTerm = query.toLowerCase();

            if (text.includes(searchTerm)) {
              const transform = item.transform;
              const x = transform[4];
              const y = transform[5];
              const fontSize = Math.abs(transform[0]);
              const canvasX = x;
              const canvasY = viewport.height - y;
              const estimatedWidth = item.width || item.str.length * fontSize * 0.6;
              const height = fontSize * 1.2;

              searchMatches.push({
                pageNum: pageNum,
                positions: [
                  {
                    x: canvasX,
                    y: canvasY - height,
                    width: estimatedWidth,
                    height: height,
                  },
                ],
                text: item.str,
              });
            }
          });
        }

        updateSearchResults();
        highlightMatches();

        if (searchMatches.length > 0) {
          currentMatchIndex = 0;
          scrollToMatch(0);
        }
      }

      function highlightMatches() {
        clearHighlights();

        searchMatches.forEach((match, index) => {
          const canvas = highlightCanvases[match.pageNum];
          if (!canvas) return;

          const { highlightCtx } = canvas;
          highlightCtx.fillStyle = index === currentMatchIndex ? 'rgba(255, 0, 0, 0.6)' : 'rgba(255, 255, 0, 0.4)';
          match.positions.forEach((pos) => {
            highlightCtx.fillRect(pos.x, pos.y, pos.width, pos.height);
            highlightCtx.strokeStyle = 'rgba(255, 0, 0, 0.8)';
            highlightCtx.lineWidth = 1;
            highlightCtx.strokeRect(pos.x, pos.y, pos.width, pos.height);
          });
        });
      }

      function clearHighlights() {
        Object.values(highlightCanvases).forEach(({ highlightCtx, highlightCanvas }) => {
          highlightCtx.clearRect(0, 0, highlightCanvas.width, highlightCanvas.height);
        });
      }

      function updateSearchResults() {
        if (searchMatches.length === 0) {
          searchResults.textContent = searchInput.value.trim() ? 'Tidak ditemukan' : '';
          prevResultBtn.disabled = true;
          nextResultBtn.disabled = true;
        } else {
          searchResults.textContent = `${currentMatchIndex + 1} dari ${searchMatches.length}`;
          prevResultBtn.disabled = currentMatchIndex === 0;
          nextResultBtn.disabled = currentMatchIndex === searchMatches.length - 1;
        }
      }

      function scrollToMatch(index) {
        if (index < 0 || index >= searchMatches.length) return;
        currentMatchIndex = index;
        clearHighlights();
        highlightMatches();
        scrollToPage(searchMatches[index].pageNum);
        updateSearchResults();
      }

      function nextMatch() {
        if (currentMatchIndex < searchMatches.length - 1) scrollToMatch(currentMatchIndex + 1);
      }

      function prevMatch() {
        if (currentMatchIndex > 0) scrollToMatch(currentMatchIndex - 1);
      }

      async function renderAllPages() {
        pdfContainer.innerHTML = '';
        const numPages = pdfDoc.numPages;

        for (let pageNum = 1; pageNum <= numPages; pageNum++) {
          const page = await pdfDoc.getPage(pageNum);
          const viewport = page.getViewport({ scale: 1.5 });

          const pageDiv = document.createElement('div');
          pageDiv.className = 'page-container';
          pageDiv.style.width = viewport.width + 'px';
          pageDiv.style.height = viewport.height + 'px';
          pageDiv.id = `page-${pageNum}`;
          pdfContainer.appendChild(pageDiv);

          // PDF Canvas
          const pdfCanvas = document.createElement('canvas');
          pdfCanvas.className = 'pdf-canvas';
          pdfCanvas.width = viewport.width;
          pdfCanvas.height = viewport.height;
          pageDiv.appendChild(pdfCanvas);

          const pdfCtx = pdfCanvas.getContext('2d');

          // Highlight Canvas
          setupHighlightCanvas(pageDiv, viewport, pageNum);

          // Draw Canvas
          const drawCanvas = document.createElement('canvas');
          drawCanvas.className = 'draw-canvas';
          drawCanvas.style.width = '100%';
          drawCanvas.style.height = '100%';
          drawCanvas.width = viewport.width;
          drawCanvas.height = viewport.height;
          pageDiv.appendChild(drawCanvas);

          setupDrawCanvas(drawCanvas, pageNum);

          const renderContext = { canvasContext: pdfCtx, viewport };
          await page.render(renderContext).promise;

          // Load saved drawing if any
          loadDrawings(pageNum);
        }
      }

      function scrollToPage(pageNum) {
        const pageElem = document.getElementById(`page-${pageNum}`);
        if (pageElem) pageElem.scrollIntoView({ behavior: 'smooth' });
      }

      function clearCanvas() {
        if (confirm('Yakin ingin menghapus semua coretan?')) {
          for (const pageNum in drawDataPerPage) {
            delete drawDataPerPage[pageNum];
          }
          localStorage.removeItem('drawDataPerPage');
          for (const pageNum in pagesCanvases) {
            const { drawCtx, drawCanvas } = pagesCanvases[pageNum];
            drawCtx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
          }

        }
      }

      function initToolbar() {
        drawToggleBtn.onclick = () => {
          drawMode = !drawMode;
          if (drawMode) {
            eraserMode = false;
            eraserToggleBtn.innerHTML = `<img src="img/no-eraser.png" alt="" style="height:20px; vertical-align:middle;">`;
            drawToggleBtn.innerHTML = `<img src="img/pencil.png" alt="Draw ON" style="height:20px; vertical-align:middle;">`;
          } else {
            drawToggleBtn.innerHTML = `<img src="img/no-pencil.png" alt="Draw OFF" style="height:20px; vertical-align:middle;">`;
          }
        };

        eraserToggleBtn.onclick = () => {
          if (!drawMode) return;
          eraserMode = !eraserMode;
          if (eraserMode) {
            eraserToggleBtn.innerHTML = `<img src="img/eraser.png" alt="" style="height:20px; vertical-align:middle;">`;
          } else {
            eraserToggleBtn.innerHTML = `<img src="img/no-eraser.png" alt="" style="height:20px; vertical-align:middle;">`;
          }
        };

        colorPicker.oninput = (e) => (brushColor = e.target.value);
        brushSizeInput.oninput = (e) => (brushSize = parseInt(e.target.value));
        eraserSizeInput.oninput = (e) => (eraserSize = parseInt(e.target.value));

        goToPageBtn.onclick = () => {
          const pageNum = parseInt(pageSelect.value);
          if (!isNaN(pageNum) && pageNum >= 1 && pageNum <= pdfDoc.numPages) {
            scrollToPage(pageNum);
          }
        };

        searchBtn.onclick = () => {
          const query = searchInput.value;
          searchInPDF(query);
        };

        searchInput.onkeypress = (e) => {
          if (e.key === 'Enter') {
            searchInPDF(searchInput.value);
          }
        };

        prevResultBtn.onclick = prevMatch;
        nextResultBtn.onclick = nextMatch;

        clearSearchBtn.onclick = () => {
          searchInput.value = '';
          searchMatches = [];
          currentMatchIndex = -1;
          clearHighlights();
          updateSearchResults();
        };

        clearCanvasBtn.onclick = () => clearCanvas();
        saveCanvasBtn.onclick = () => saveDrawingsToStorage();
      }

      async function loadPDF() {
        try {
          pdfDoc = await pdfjsLib.getDocument(url).promise;

          // Populate page selector
          pageSelect.innerHTML = '';
          for (let i = 1; i <= pdfDoc.numPages; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            pageSelect.appendChild(option);
          }

          loadSavedDrawings();

          await renderAllPages();
        } catch (error) {
          console.error('Error loading PDF:', error);
          pdfContainer.innerHTML =
            '<div style="text-align: center; padding: 50px;">Error loading PDF. Please check the URL.</div>';
        }
      }

      // Initialize app
      initToolbar();
      loadPDF();
    </script>
  </body>
</html>


