/**
 * Intelligent Filter Engine - v1.7.0
 * Now with explicit "Buscar" button, Enter key, and loading spinner.
 */

document.addEventListener('DOMContentLoaded', () => {
    const filterSearch = document.getElementById('filter-search');
    const filterCoord = document.getElementById('filter-coordinacion');
    const filterStart = document.getElementById('filter-date-start');
    const filterEnd = document.getElementById('filter-date-end');
    const btnReset = document.getElementById('btn-reset-filters');
    const btnSearch = document.getElementById('btn-search');
    const spinner = document.getElementById('search-spinner');

    if (!filterSearch) return; // Not on dashboard

    function getFilters() {
        return {
            global: filterSearch.value.trim(),
            coordinacion: filterCoord ? filterCoord.value : '',
            date_start: filterStart ? filterStart.value : '',
            date_end: filterEnd ? filterEnd.value : ''
        };
    }

    async function triggerSync() {
        const filters = getFilters();

        // Show spinner
        if (spinner) spinner.style.display = 'flex';
        if (btnSearch) {
            btnSearch.disabled = true;
            btnSearch.textContent = 'Buscando...';
        }

        try {
            if (window.loadDashboardKPIs) {
                await window.loadDashboardKPIs(filters);
            }
        } catch (err) {
            console.error('Filter sync error:', err);
        } finally {
            // Hide spinner
            if (spinner) spinner.style.display = 'none';
            if (btnSearch) {
                btnSearch.disabled = false;
                btnSearch.textContent = 'Buscar';
            }
        }
    }

    // Button click
    if (btnSearch) {
        btnSearch.addEventListener('click', triggerSync);
    }

    // Enter key on search input
    filterSearch.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            triggerSync();
        }
    });

    // Dropdown change triggers immediately
    if (filterCoord) {
        filterCoord.addEventListener('change', triggerSync);
    }

    // Date changes trigger immediately
    [filterStart, filterEnd].forEach(el => {
        if (el) el.addEventListener('change', triggerSync);
    });

    // Reset Logic
    if (btnReset) {
        btnReset.addEventListener('click', () => {
            filterSearch.value = '';
            if (filterCoord) filterCoord.value = '';
            if (filterStart) filterStart.value = '';
            if (filterEnd) filterEnd.value = '';
            triggerSync();
        });
    }
});
