class AutoRefresh {
    constructor(config = {}) {
        this.apiUrl = config.apiUrl;
        this.interval = config.interval || 5000;
        this.selectors = config.selectors || {};
        this.onUpdate = config.onUpdate || null;
        this.cachedElements = {};
        this.intervalId = null;
        this.lastData = null;
        this.isActive = true;
        
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(() => this.start(), { timeout: 100 });
        } else {
            setTimeout(() => this.start(), 100);
        }
    }

    start() {
        if (!this.isActive) return;
        this.cacheElements();
        this.fetch();
        this.intervalId = setInterval(() => this.fetch(), this.interval);
    }

    cacheElements() {
        Object.entries(this.selectors).forEach(([key, selector]) => {
            const element = document.querySelector(selector);
            if (element) {
                this.cachedElements[key] = element;
            }
        });
    }

    fetch() {
        if (!this.isActive) return;
        fetch(this.apiUrl, { signal: AbortSignal.timeout(3000) })
            .then(response => response.json())
            .then(data => {
                if (JSON.stringify(data) !== JSON.stringify(this.lastData)) {
                    this.updateUI(data);
                    this.lastData = data;
                    if (this.onUpdate) this.onUpdate(data);
                }
            })
            .catch(error => {
                if (error.name !== 'AbortError') {
                    console.log('Auto-refresh error:', error);
                }
            });
    }

    updateUI(data) {
        Object.entries(this.cachedElements).forEach(([key, element]) => {
            if (data[key] && element.textContent !== String(data[key])) {
                element.textContent = data[key];
            }
        });
    }

    stop() {
        this.isActive = false;
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }
}
