/**
 * Intelligent Filter Engine - v1.0.0
 * Real-time dashboard filtering logic
 */

document.addEventListener('DOMContentLoaded', () => {
    const filterSearch = document.getElementById('filter-search');
    const filterCoord = document.getElementById('filter-coordinacion');
    const filterStart = document.getElementById('filter-date-start');
    const filterEnd = document.getElementById('filter-date-end');
    const btnReset = document.getElementById('btn-reset-filters');

    if (!filterSearch) return; // Not on dashboard

    // 1. Collect and Trigger Sync
    const triggerSync = debounce(() => {
        const filters = {
            global: filterSearch.value.trim(),
            coordinacion: filterCoord.value,
            date_start: filterStart.value,
            date_end: filterEnd.value
        };

        console.log("Triggering filter sync with:", filters);
        if (window.loadDashboardKPIs) {
            window.loadDashboardKPIs(filters);
        }
    }, 400);

    // 2. Event Listeners
    [filterSearch, filterStart, filterEnd].forEach(el => {
        el.addEventListener('input', triggerSync);
    });

    filterCoord.addEventListener('change', triggerSync);

    // 3. Reset Logic
    if (btnReset) {
        btnReset.addEventListener('click', () => {
            filterSearch.value = '';
            filterCoord.value = '';
            filterStart.value = '';
            filterEnd.value = '';
            triggerSync();
        });
    }

    // Utility: Debounce (simplified copy to ensure isolation)
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
});
