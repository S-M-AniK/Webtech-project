document.addEventListener("DOMContentLoaded", function () {
  // --- Auth Modal Logic ---
  const modal = document.getElementById("authModal");
  const closeModal = document.getElementById("closeModal");
  const showSignup = document.getElementById("showSignup");
  const showLogin = document.getElementById("showLogin");
  const loginForm = document.getElementById("loginForm");
  const signupForm = document.getElementById("signupForm");

  function openModal(e) {
    e.preventDefault();
    if (modal) modal.style.display = "flex";
  }

  document.querySelectorAll(".btn-login, .login-link").forEach((btn) => {
    if (btn) btn.addEventListener("click", openModal);
  });

  if (closeModal) {
    closeModal.addEventListener("click", function () {
      modal.style.display = "none";
      //MediaSourceHandle.style.display = "external";
    });
  }

  window.addEventListener("click", function (e) {
    if (e.target == modal) {
      modal.style.display = "none";
    }
  });

  if (showSignup) {
    showSignup.addEventListener("click", function (e) {
      e.preventDefault();
      loginForm.classList.remove("active");
      signupForm.classList.add("active");
    });
  }

  if (showLogin) {
    showLogin.addEventListener("click", function (e) {
      e.preventDefault();
      signupForm.classList.remove("active");
      loginForm.classList.add("active");
    });
  }

  // --- My Books Page Tab Logic ---
  const tabs = document.querySelectorAll(".tab-link");
  const tabContents = document.querySelectorAll(".tab-content");
  if (tabs.length > 0) {
    function activateTab(tabLink) {
      const target = tabLink.getAttribute("href");
      tabs.forEach((tab) => tab.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));
      tabLink.classList.add("active");
      document.querySelector(target).classList.add("active");
    }
    tabs.forEach((tab) => {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        activateTab(this);
      });
    });
    if (window.location.hash) {
      const tabLink = document.querySelector(
        `.tab-link[href="${window.location.hash}"]`
      );
      if (tabLink) activateTab(tabLink);
    }
  }

  // --- NOTIFICATION SYSTEM ---
  const notificationBell = document.getElementById("notificationBell");
  const notificationCount = document.getElementById("notificationCount");
  const notificationDropdown = document.getElementById("notificationDropdown");

  async function fetchNotifications() {
    try {
      const response = await fetch("index.php?page=get-notifications");
      const notifications = await response.json();
      updateNotificationUI(notifications);
    } catch (error) {
      console.error("Error fetching notifications:", error);
    }
  }

  function updateNotificationUI(notifications) {
    if (!notificationCount || !notificationDropdown) return;
    const unread = notifications.filter((n) => n.is_read == 0);
    notificationCount.textContent = unread.length;
    notificationCount.style.display = unread.length > 0 ? "flex" : "none";

    if (notifications.length === 0) {
      notificationDropdown.innerHTML =
        '<div class="notification-item">No new notifications.</div>';
    } else {
      notificationDropdown.innerHTML = "";
      notifications.forEach((n) => {
        const item = document.createElement("a");
        item.href = `index.php?page=book&id=${n.book_id}`;
        item.className =
          "notification-item" + (n.is_read == 0 ? " unread" : "");
        item.innerHTML = `
                    <div class="notification-text">
                        <strong>${
                          n.author_name
                        }</strong> replied to your review on <strong>${
          n.book_title
        }</strong>.
                    </div>
                    <div class="notification-time">${new Date(
                      n.created_at
                    ).toLocaleDateString()}</div>
                `;
        notificationDropdown.appendChild(item);
      });
    }
  }

  if (notificationBell) {
    fetchNotifications();

    notificationBell.addEventListener("click", async function (e) {
      e.preventDefault();
      notificationDropdown.classList.toggle("active");

      if (
        notificationDropdown.classList.contains("active") &&
        parseInt(notificationCount.textContent) > 0
      ) {
        await fetch("index.php?page=mark-notifications-read");
        notificationCount.textContent = "0";
        notificationCount.style.display = "none";
        document
          .querySelectorAll(".notification-item.unread")
          .forEach((item) => {
            item.classList.remove("unread");
          });
      }
    });
  }
});
