function initializeDispatchesForm() {
    const form = document.getElementById('dispatchesForm');
    const resultsContainer = document.getElementById('resultsContainer');

    if (!form || !resultsContainer) {
        console.log('Form or results container not found yet');
        return false;
    }

    console.log('Dispatches form initialized');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const dispatchId = form.querySelector('input[name="dispatch_id"]').value;

        if (!dispatchId) {
            resultsContainer.innerHTML = '<div class="alert alert-warning">Please enter a Dispatch ID</div>';
            return;
        }

        resultsContainer.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

        fetch(`pages/stores/store-actions/fetch_bulk_dispatch.php?dispatch_id=${encodeURIComponent(dispatchId)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    resultsContainer.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    return;
                }

                if (data.specific_dispatches && data.specific_dispatches.length > 0) {
                    let tableHTML = `
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Stock ID</th>
                                        <th>Project</th>
                                        <th>Destination</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th>Received By</th>
                                        <th>Issued By</th>
                                        <th>Status</th>
                                        <th>Dispatch ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    data.specific_dispatches.forEach(dispatch => {
                        tableHTML += `
                            <tr>
                                <td>${dispatch.id || ''}</td>
                                <td>${dispatch.stock_id || ''}</td>
                                <td>${dispatch.project || ''}</td>
                                <td>${dispatch.destination || ''}</td>
                                <td>${dispatch.quantity || ''}</td>
                                <td>${dispatch.dispatch_date || ''}</td>
                                <td>${dispatch.receiver || ''}</td>
                                <td>${dispatch.dispatcher || ''}</td>
                                <td>${dispatch.status || ''}</td>
                                <td>${dispatch.dispatch_id || ''}</td>
                            </tr>
                        `;
                    });
                    tableHTML += '</tbody></table></div>';
                    resultsContainer.innerHTML = tableHTML;
                } else {
                    resultsContainer.innerHTML = '<div class="alert alert-info">No records found</div>';
                }
            })
            .catch(error => {
                resultsContainer.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                console.error('Fetch error:', error);
            });
    });
    return true;
}


// Try to initialize immediately
if (!initializeDispatchesForm()) {
    // Watch for DOM changes if form isn't present initially
    const observer = new MutationObserver(function(mutations, observerInstance) {
        if (initializeDispatchesForm()) {
            observerInstance.disconnect();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}