/* ============================================
   TRIVIA PAGE LOGIC (FANDOM API INTEGRATION)
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {
    // Hide global loading screen
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        setTimeout(() => {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.pointerEvents = 'none';
        }, 800);
    }
    
    initTriviaPage();
});

// Curated list of popular Pirates of the Caribbean topics
const TRIVIA_TOPICS = [
    { title: 'The Kraken', pageQuery: 'Kraken', localImage: 'assets/images/home/new images/kraken hunt.jpg' },
    { title: 'Davy Jones', pageQuery: 'Davy_Jones', localImage: 'assets/images/home/davy jones.jpeg' },
    { title: 'The Black Pearl', pageQuery: 'Black_Pearl', localImage: 'assets/images/ships/black pearl.jpg' },
    { title: 'Captain Jack Sparrow', pageQuery: 'Jack_Sparrow', localImage: 'assets/images/characters/captain jack sparrow.jpeg' },
    { title: 'Cursed Aztec Gold', pageQuery: 'Aztec_gold', localImage: 'assets/images/profile/relics/relic-aztec-coin.png' },
    { title: 'Flying Dutchman', pageQuery: 'Flying_Dutchman', localImage: 'assets/images/ships/Flying Dutchman.jpg' },
    { title: 'East India Trading Company', pageQuery: 'East_India_Trading_Company', localImage: 'assets/images/characters/beckett.jpg' },
    { title: 'The Brethren Court', pageQuery: 'Brethren_Court', localImage: 'assets/images/BrethrenCourt.jpeg' },
    { title: 'Hector Barbossa', pageQuery: 'Hector_Barbossa', localImage: 'assets/images/characters/Barbosa.jpg' },
    { title: 'Isla de Muerta', pageQuery: 'Isla_de_Muerta', localImage: 'assets/images/IsladeMuerta.jpeg' }
];

function initTriviaPage() {
    const listEl = document.getElementById('topic-list');
    
    // Render the sidebar topics
    TRIVIA_TOPICS.forEach((topic, index) => {
        const li = document.createElement('li');
        const btn = document.createElement('button');
        btn.className = 'topic-btn';
        btn.textContent = topic.title;
        btn.innerHTML = `${topic.title} <span>→</span>`;
        
        btn.addEventListener('click', () => {
            // Update active state
            document.querySelectorAll('.topic-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Fetch and render
            fetchTrivia(topic);
        });
        
        li.appendChild(btn);
        listEl.appendChild(li);
    });
}

async function fetchTrivia(topic) {
    const pageQuery = topic.pageQuery;
    const displayTitle = topic.title;
    
    const initialEl = document.getElementById('journal-initial');
    const loadingEl = document.getElementById('journal-loading');
    const contentEl = document.getElementById('journal-content');
    
    // UI Transitions
    initialEl.classList.add('hidden');
    contentEl.classList.add('hidden');
    loadingEl.classList.remove('hidden');

    // Fandom Wiki doesn't support prop=extracts, so we must use action=parse for HTML and parse it ourselves,
    // and a separate call for the thumbnail image.
    const textUrl = `https://pirates.fandom.com/api.php?action=parse&page=${encodeURIComponent(pageQuery)}&format=json&prop=text&redirects=1&origin=*`;
    const imgUrl = `https://pirates.fandom.com/api.php?action=query&prop=pageimages&titles=${encodeURIComponent(pageQuery)}&format=json&pithumbsize=400&redirects=1&origin=*`;

    try {
        const [textRes, imgRes] = await Promise.all([
            fetch(textUrl),
            fetch(imgUrl)
        ]);
        
        const textData = await textRes.json();
        const imgData = await imgRes.json();
        
        if (textData.error) {
            throw new Error(textData.error.info);
        }

        // Extract Image URL: Prefer local image over API image
        let imageUrl = topic.localImage ? (window.APP_BASE || '') + '/' + topic.localImage : null;
        if (!imageUrl) {
            const pages = imgData.query?.pages;
            if (pages) {
                const pageId = Object.keys(pages)[0];
                if (pages[pageId]?.thumbnail) {
                    imageUrl = pages[pageId].thumbnail.source;
                }
            }
        }

        // Extract Text from HTML
        const htmlRaw = textData.parse.text["*"];
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = htmlRaw;
        
        // Find all root-level paragraphs
        const pTags = Array.from(tempDiv.querySelectorAll('.mw-parser-output > p'));
        
        // Filter out empty paragraphs or tiny metadata fragments
        const validParagraphs = pTags.filter(p => p.textContent.trim().length > 30);
        
        // Take the first 3 paragraphs and strip out citation brackets [1]
        let formattedText = validParagraphs.slice(0, 3).map(p => {
            return `<p>${p.textContent.replace(/\[\d+\]/g, '')}</p>`;
        }).join('');

        if (!formattedText) {
            formattedText = "<p>The archives yielded no summary for this tale.</p>";
        }

        renderTriviaContent(formattedText, imageUrl, displayTitle, pageQuery);

    } catch (error) {
        console.error("Trivia Fetch Error:", error);
        
        loadingEl.classList.add('hidden');
        contentEl.classList.remove('hidden');
        
        document.getElementById('topic-title').textContent = "A Tale Lost to the Sea";
        document.getElementById('topic-text').innerHTML = `<p>Alas, the archives could not locate the tale of <b>${displayTitle}</b>. The pages may be torn, or the connection lost to the abyss.</p>`;
        document.getElementById('topic-image').classList.add('hidden');
        document.getElementById('wiki-link').href = `https://pirates.fandom.com/wiki/Main_Page`;
        document.getElementById('wiki-link').textContent = "Return to Main Page";
    }
}

function renderTriviaContent(formattedText, imageUrl, displayTitle, pageQuery) {
    const loadingEl = document.getElementById('journal-loading');
    const contentEl = document.getElementById('journal-content');
    
    // Update DOM
    document.getElementById('topic-title').textContent = displayTitle;
    document.getElementById('topic-text').innerHTML = formattedText;
    
    // Handle Image
    const imgEl = document.getElementById('topic-image');
    if (imageUrl) {
        imgEl.src = imageUrl;
        imgEl.alt = displayTitle;
        imgEl.classList.remove('hidden');
    } else {
        imgEl.classList.add('hidden');
    }
    
    // Link to full wiki page
    const wikiLink = document.getElementById('wiki-link');
    wikiLink.href = `https://pirates.fandom.com/wiki/${pageQuery}`;
    wikiLink.textContent = "See full details on Pirates Wiki \u2192";
    
    // Show content
    loadingEl.classList.add('hidden');
    contentEl.classList.remove('hidden');
}
