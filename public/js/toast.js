/**
 * Toast Notification System
 * A reusable toast notification system with Bootstrap support
 * Usage: showToast(type, title, message)
 * Types: success, error, warning, info
 */

// Global toast control state
window.__toastState = {
    lastKey: '',
    lastAt: 0,
    suppressBlurToasts: false
};

/**
 * Fallback toast function (works immediately)
 * Used when Bootstrap is not yet loaded
 */
function createFallbackToast(type, title, message) {
    console.log('[Toast:FALLBACK]', { type, title, message });
    
    // De-duplicate within 800ms
    const key = `${type}|${title}|${message}`;
    const now = Date.now();
    if (window.__toastState && window.__toastState.lastKey === key && (now - window.__toastState.lastAt) < 800) {
        return;
    }
    if (window.__toastState) { 
        window.__toastState.lastKey = key; 
        window.__toastState.lastAt = now; 
    }
    
    // Clear bootstrap container if exists to ensure single toast
    const bs = document.getElementById('bsToastContainer');
    if (bs) while (bs.firstChild) bs.removeChild(bs.firstChild);
    
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    // Ensure only one fallback toast
    while (container.firstChild) container.removeChild(container.firstChild);
    
    const toast = document.createElement('div');
    toast.className = 'toast ' + (type || 'error');
    toast.style.background = 'white';
    toast.style.borderRadius = '12px';
    toast.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
    toast.style.marginBottom = '10px';
    toast.style.padding = '16px';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.borderLeft = '4px solid';
    toast.style.minWidth = '300px';
    
    if (type === 'success') toast.style.borderLeftColor = '#28a745';
    else if (type === 'warning') toast.style.borderLeftColor = '#ffc107';
    else if (type === 'info') toast.style.borderLeftColor = '#17a2b8';
    else toast.style.borderLeftColor = '#dc3545';
    
    toast.innerHTML = `
        <div style="margin-right:12px;font-weight:700;">${title || ''}</div>
        <div style="flex:1;color:#666;">${message || ''}</div>
    `;
    
    container.appendChild(toast);
    setTimeout(() => { 
        if (toast.parentNode) toast.parentNode.removeChild(toast); 
    }, 4000);
}

/**
 * Bootstrap toast function (preferred)
 * Used when Bootstrap is loaded
 */
function createBootstrapToast(type, title, message) {
    // De-duplicate within 800ms
    const key = `${type}|${title}|${message}`;
    const now = Date.now();
    if (window.__toastState && window.__toastState.lastKey === key && (now - window.__toastState.lastAt) < 800) {
        return;
    }
    if (window.__toastState) { 
        window.__toastState.lastKey = key; 
        window.__toastState.lastAt = now; 
    }
    
    const containerId = 'bsToastContainer';
    let container = document.getElementById(containerId);
    if (!container) {
        container = document.createElement('div');
        container.id = containerId;
        container.style.position = 'fixed';
        container.style.top = '16px';
        container.style.left = '50%';
        container.style.transform = 'translateX(-50%)';
        container.style.zIndex = '1080';
        container.style.pointerEvents = 'none';
        container.setAttribute('aria-live', 'polite');
        container.setAttribute('aria-atomic', 'true');
        document.body.appendChild(container);
    }
    
    // Only one toast at a time
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }
    
    // Also clear fallback container if present
    const fb = document.getElementById('toastContainer');
    if (fb) while (fb.firstChild) fb.removeChild(fb.firstChild);

    const typeClasses = {
        success: { bg: 'bg-success', icon: '✅' },
        error:   { bg: 'bg-danger',  icon: '⚠️' },
        warning: { bg: 'bg-warning', icon: '⚠️' },
        info:    { bg: 'bg-info',    icon: 'ℹ️' }
    };
    const cfg = typeClasses[type] || typeClasses.info;

    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center show text-white border-0 shadow rounded-3 ${cfg.bg}`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.style.minWidth = '320px';
    toastEl.style.pointerEvents = 'auto';
    toastEl.style.padding = '8px 12px';
    toastEl.innerHTML = `
        <div class="toast-body d-flex align-items-center gap-2 w-100 justify-content-between" style="font-weight:500;">
            <div class="d-flex align-items-center gap-2" style="flex:1 1 auto; min-width:0;">
                <span style="font-size:16px; flex:0 0 auto;">${cfg.icon}</span>
                <div style="line-height:1.3; overflow:hidden; text-overflow:ellipsis;">
                    <div style="font-size:14px;">${title || ''}</div>
                    <div style="font-size:13px;opacity:.95;">${message || ''}</div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" style="margin-left:auto;" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    container.appendChild(toastEl);
    const toast = new window.bootstrap.Toast(toastEl, { delay: 3000, autohide: true });
    toast.show();

    toastEl.addEventListener('hidden.bs.toast', function() {
        if (toastEl && toastEl.parentNode) toastEl.parentNode.removeChild(toastEl);
    });
}

/**
 * Main showToast function
 * Automatically chooses between fallback and Bootstrap toast
 */
function showToast(type, title, message) {
    // Check if Bootstrap is available
    if (window.bootstrap && window.bootstrap.Toast) {
        createBootstrapToast(type, title, message);
    } else {
        createFallbackToast(type, title, message);
    }
}

/**
 * Initialize toast system
 * Sets up the showToast function and Bootstrap override
 */
function initToastSystem() {
    // Set initial fallback function
    if (typeof window.showToast !== 'function') {
        window.showToast = showToast;
    }
    
    // Override with Bootstrap Toast when Bootstrap loads
    window.addEventListener('load', function() {
        try {
            if (!window.bootstrap || !window.bootstrap.Toast) return;
            
            window.showToast = function(type, title, message) {
                createBootstrapToast(type, title, message);
            };
        } catch (err) {
            console.error('[Toast System] Failed to initialize Bootstrap toast', err);
        }
    });
}

/**
 * Clear all toasts
 */
function clearAllToasts() {
    const containers = ['bsToastContainer', 'toastContainer'];
    containers.forEach(containerId => {
        const container = document.getElementById(containerId);
        if (container) {
            while (container.firstChild) {
                container.removeChild(container.firstChild);
            }
        }
    });
}

/**
 * Set suppress blur toasts (useful for form submissions)
 */
function setSuppressBlurToasts(suppress) {
    if (window.__toastState) {
        window.__toastState.suppressBlurToasts = suppress;
    }
}

// Auto-initialize when script loads
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initToastSystem);
} else {
    initToastSystem();
}

// Export functions for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        showToast,
        clearAllToasts,
        setSuppressBlurToasts,
        initToastSystem
    };
}
