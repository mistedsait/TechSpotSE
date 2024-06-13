var Constants = {
    get_api_base_url: function () {
      if (location.hostname == "localhost") {
        return "http://localhost/TechSpot/backend/";
      } else {
        return "https://king-prawn-app-fhuhs.ondigitalocean.app/";
      }
    },
  };