/**
 * AirwaysCoupons.com - Interactive Engine
 * Handles Blurry Code Unblur, Random Code Generator, Copy to Clipboard,
 * Phone Lead Modal Triggers, Search & Filters, and FAQ Accordions.
 */

// 1. Initial Coupons Dataset
const dealsData = [
  {
    id: 1,
    airline: "Delta Air Lines",
    airlineCode: "DL",
    logo: "✈️",
    discount: "$150 OFF",
    origin: "New York (JFK)",
    destination: "Los Angeles (LAX)",
    category: "domestic",
    classType: "Business / First",
    validTill: "Ends Today",
    rating: "4.9/5",
    codePrefix: "DELTA",
    featured: true
  },
  {
    id: 2,
    airline: "American Airlines",
    airlineCode: "AA",
    logo: "🦅",
    discount: "$120 OFF",
    origin: "Miami (MIA)",
    destination: "London (LHR)",
    category: "international",
    classType: "Economy / Main",
    validTill: "Limited Seats",
    rating: "4.8/5",
    codePrefix: "AMEX",
    featured: true
  },
  {
    id: 3,
    airline: "United Airlines",
    airlineCode: "UA",
    logo: "🌐",
    discount: "$135 OFF",
    origin: "Chicago (ORD)",
    destination: "Cancun (CUN)",
    category: "international",
    classType: "Business Class",
    validTill: "Expires Soon",
    rating: "4.9/5",
    codePrefix: "UNITED",
    featured: true
  },
  {
    id: 4,
    airline: "Southwest Airlines",
    airlineCode: "WN",
    logo: "❤️",
    discount: "20% OFF",
    origin: "Dallas (DAL)",
    destination: "Orlando (MCO)",
    category: "domestic",
    classType: "Wanna Get Away",
    validTill: "Hot Deal",
    rating: "4.7/5",
    codePrefix: "SWFLY",
    featured: false
  },
  {
    id: 5,
    airline: "JetBlue Airways",
    airlineCode: "B6",
    logo: "💙",
    discount: "$85 OFF",
    origin: "Boston (BOS)",
    destination: "San Francisco (SFO)",
    category: "domestic",
    classType: "Mint Suite",
    validTill: "Ends Today",
    rating: "4.9/5",
    codePrefix: "JBLUE",
    featured: false
  },
  {
    id: 6,
    airline: "Qatar Airways",
    airlineCode: "QR",
    logo: "🇶🇦",
    discount: "$250 OFF",
    origin: "New York (JFK)",
    destination: "Doha (DOH) / Asia",
    category: "international",
    classType: "Qsuite Business",
    validTill: "Exclusive Phone Deal",
    rating: "5.0/5",
    codePrefix: "QATAR",
    featured: true
  },
  {
    id: 7,
    airline: "Alaska Airlines",
    airlineCode: "AS",
    logo: "🌲",
    discount: "$95 OFF",
    origin: "Seattle (SEA)",
    destination: "Honolulu (HNL)",
    category: "domestic",
    classType: "First Class",
    validTill: "Limited Coupons",
    rating: "4.8/5",
    codePrefix: "ALASKA",
    featured: false
  },
  {
    id: 8,
    airline: "Emirates",
    airlineCode: "EK",
    logo: "🇦🇪",
    discount: "$200 OFF",
    origin: "Los Angeles (LAX)",
    destination: "Dubai (DXB)",
    category: "international",
    classType: "Business Class",
    validTill: "Today Only",
    rating: "4.9/5",
    codePrefix: "FLYEK",
    featured: true
  }
];

// Helper: Generate Random Code (e.g. DELTA-849201 or USFLY-7839)
function generateRandomCode(prefix = "USFLY") {
  const randomNum = Math.floor(100000 + Math.random() * 900000);
  return `${prefix}-${randomNum}`;
}

// 2. Render Coupons Function
function renderCoupons(dealsToRender) {
  const container = document.getElementById("couponsGrid");
  if (!container) return;

  if (dealsToRender.length === 0) {
    container.innerHTML = `
      <div style="grid-column: 1/-1; text-align: center; padding: 4rem 1rem; background: rgba(17, 34, 64, 0.5); border-radius: 16px;">
        <h3 style="font-size: 1.5rem; color: #fff; margin-bottom: 0.5rem;">No Specific Coupon Found</h3>
        <p style="color: #94a3b8; margin-bottom: 1.5rem;">Don't worry! Call our 24/7 hotline directly to get unadvertised phone fares for any flight route.</p>
        <a href="tel:+18005550199" class="btn-call">📞 Call +1 (800) 555-0199 Now</a>
      </div>
    `;
    return;
  }

  container.innerHTML = dealsToRender.map(deal => {
    return `
      <div class="coupon-card" data-category="${deal.category}" data-id="${deal.id}">
        <div class="coupon-header">
          <div class="airline-badge">
            <div class="airline-icon">${deal.logo}</div>
            <span>${deal.airline}</span>
          </div>
          <div class="discount-badge">${deal.discount}</div>
        </div>

        <div class="coupon-body">
          <div class="route-info">
            <div class="route-cities">
              ${deal.origin} <span class="arrow">➔</span> ${deal.destination}
            </div>
            <div class="route-details">
              <span>✈️ ${deal.classType}</span>
              <span>🔥 ${deal.validTill}</span>
            </div>
          </div>

          <!-- BLURRY CODE CONTAINER -->
          <div class="coupon-code-wrapper">
            <div class="code-display blurred" id="code-display-${deal.id}">
              •••-••••-•••
            </div>

            <div class="blur-overlay" id="blur-overlay-${deal.id}">
              <button class="btn-reveal" onclick="revealSecretCode(${deal.id}, '${deal.codePrefix}')">
                🔓 Reveal Secret Code
              </button>
            </div>
          </div>

          <div class="coupon-action" id="action-box-${deal.id}">
            <button class="btn-claim-call" onclick="triggerPhoneClaim(${deal.id}, '${deal.codePrefix}')">
              📞 Call +1 (800) 555-0199 to Claim
            </button>
          </div>
        </div>
      </div>
    `;
  }).join('');
}

// 3. Reveal Secret Code Logic
window.revealSecretCode = function(dealId, prefix) {
  const codeDisplay = document.getElementById(`code-display-${dealId}`);
  const overlay = document.getElementById(`blur-overlay-${dealId}`);
  const actionBox = document.getElementById(`action-box-${dealId}`);

  if (!codeDisplay || !overlay) return;

  // Generate random secret code
  const generatedCode = generateRandomCode(prefix);

  // Unblur effect
  codeDisplay.textContent = generatedCode;
  codeDisplay.classList.remove('blurred');
  codeDisplay.classList.add('revealed');
  overlay.classList.add('hidden');

  // Update action box to show Copy & Direct Call
  actionBox.innerHTML = `
    <button class="btn-copy-code" onclick="copyToClipboard('${generatedCode}')">
      📋 Copy Code: ${generatedCode}
    </button>
    <button class="btn-claim-call" onclick="openClaimModal('${generatedCode}')">
      📞 Call Agent with Code
    </button>
  `;

  // Auto copy to clipboard & open modal
  copyToClipboard(generatedCode);
  openClaimModal(generatedCode);
};

// 4. Copy to Clipboard & Toast
window.copyToClipboard = function(code) {
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(code).then(() => {
      showToast(`Clipboard: Secret Code "${code}" Copied!`);
    }).catch(() => {
      showToast(`Secret Code: ${code}`);
    });
  } else {
    showToast(`Secret Code: ${code}`);
  }
};

function showToast(message) {
  let toastContainer = document.getElementById('toastContainer');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'toastContainer';
    toastContainer.className = 'toast-container';
    document.body.appendChild(toastContainer);
  }

  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerHTML = `<span>✅</span> <span>${message}</span>`;
  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.4s ease';
    setTimeout(() => toast.remove(), 400);
  }, 3500);
}

// 5. Open / Close Phone Claim Modal
window.openClaimModal = function(code) {
  const modalBackdrop = document.getElementById('claimModal');
  const codeValDisplay = document.getElementById('modalCodeDisplay');
  
  if (codeValDisplay) {
    codeValDisplay.textContent = code;
  }

  if (modalBackdrop) {
    modalBackdrop.classList.add('active');
  }
};

window.closeClaimModal = function() {
  const modalBackdrop = document.getElementById('claimModal');
  if (modalBackdrop) {
    modalBackdrop.classList.remove('active');
  }
};

window.triggerPhoneClaim = function(dealId, prefix) {
  const codeDisplay = document.getElementById(`code-display-${dealId}`);
  if (codeDisplay && codeDisplay.classList.contains('revealed')) {
    openClaimModal(codeDisplay.textContent.trim());
  } else {
    revealSecretCode(dealId, prefix);
  }
};

// 6. Category Filter Logic
function initFilters() {
  const filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const cat = btn.getAttribute('data-filter');
      if (cat === 'all') {
        renderCoupons(dealsData);
      } else {
        const filtered = dealsData.filter(d => d.category === cat);
        renderCoupons(filtered);
      }
    });
  });
}

// 7. Search Form Handler
function initSearchForm() {
  const searchForm = document.getElementById('flightSearchForm');
  if (!searchForm) return;

  searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const fromInput = document.getElementById('searchFrom').value.toLowerCase().trim();
    const toInput = document.getElementById('searchTo').value.toLowerCase().trim();
    const airlineInput = document.getElementById('searchAirline').value.toLowerCase();

    // Reset category filter active button to 'All'
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.classList.remove('active');
      if (btn.getAttribute('data-filter') === 'all') {
        btn.classList.add('active');
      }
    });

    const filtered = dealsData.filter(deal => {
      const matchFrom = !fromInput || deal.origin.toLowerCase().includes(fromInput);
      const matchTo = !toInput || deal.destination.toLowerCase().includes(toInput);
      const matchAirline = !airlineInput || airlineInput === 'all' || deal.airline.toLowerCase().includes(airlineInput);

      return matchFrom && matchTo && matchAirline;
    });

    renderCoupons(filtered);

    // Smooth scroll to coupons grid
    document.getElementById('dealsSection')?.scrollIntoView({ behavior: 'smooth' });
  });
}

// 8. FAQ Accordion Toggle
function initFaq() {
  const faqQuestions = document.querySelectorAll('.faq-question');
  faqQuestions.forEach(btn => {
    btn.addEventListener('click', () => {
      const parent = btn.parentElement;
      const isActive = parent.classList.contains('active');

      document.querySelectorAll('.faq-item').forEach(item => item.classList.remove('active'));

      if (!isActive) {
        parent.classList.add('active');
      }
    });
  });
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  renderCoupons(dealsData);
  initFilters();
  initSearchForm();
  initFaq();

  // Close modal when clicking backdrop
  const modalBackdrop = document.getElementById('claimModal');
  if (modalBackdrop) {
    modalBackdrop.addEventListener('click', (e) => {
      if (e.target === modalBackdrop) {
        closeClaimModal();
      }
    });
  }
});
