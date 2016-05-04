<?php

/**
 * Created by PhpStorm.
 * User: davichoso
 * Date: 2/22/16
 * Time: 2:50 PM
 * info --- code taken from Pierre RASO - eX Nihili <pierre@exnihili.com> github
 */



class RunKeeperAPI {
    
    private $client_id;
	private $client_secret;
	private $auth_url;
	private $access_token_url;
	private $redirect_uri;
	private $api_base_url;
	private $api_conf_file;
	public $api_conf;
	public $api_created = false;
	public $api_last_error = null;
	public $access_token = null;
	public $token_type = 'Bearer';
	public $requestRedirectUrl = null;
	public $api_request_log = null;    
    public $config = '{
  "App": {
    "client_id": "cf728f6345b442859c2d8622ae973288",
    "client_secret": "70db8492e10848f9adaddb2c9498ed03",
    "auth_url": "https://runkeeper.com/apps/authorize",
    "access_token_url": "https://runkeeper.com/apps/token",
    "redirect_uri": "http://angular.localhost/token.php",
    "api_base_url": "https://api.runkeeper.com"
  },
  "Interfaces": {
    "User": {
      "Name": "User",
      "Media_Type": "application/vnd.com.runkeeper.User+json",
      "Read": {
        "Method": "GET",
        "Url": "/user"
      },
      "Fields": {
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "profile": {
          "name": "profile",
          "type": "string",
          "editable": false
        },
        "settings": {
          "name": "settings",
          "type": "string",
          "editable": false
        },
        "fitness_activities": {
          "name": "fitness_activities",
          "type": "string",
          "editable": false
        },
        "strength_training_activities": {
          "name": "strength_training_activities",
          "type": "string",
          "editable": false
        },
        "background_activities": {
          "name": "background_activities",
          "type": "string",
          "editable": false
        },
        "sleep": {
          "name": "sleep",
          "type": "string",
          "editable": false
        },
        "nutrition": {
          "name": "nutrition",
          "type": "string",
          "editable": false
        },
        "weight": {
          "name": "weight",
          "type": "string",
          "editable": false
        },
        "general_measurements": {
          "name": "general_measurements",
          "type": "string",
          "editable": false
        },
        "diabetes": {
          "name": "diabetes",
          "type": "string",
          "editable": false
        },
        "records": {
          "name": "records",
          "type": "string",
          "editable": false
        },
        "team": {
          "name": "team",
          "type": "string",
          "editable": false
        }
      }
    },
    "Profile": {
      "Name": "Profile",
      "Media_Type": "application/vnd.com.runkeeper.Profile+json",
      "Read": {
        "Method": "GET",
        "Url": "/profile"
      },
      "Update": {
        "Method": "PUT",
        "Url": "/profile"
      },
      "Fields": {
        "name": {
          "name": "name",
          "type": "string",
          "editable": false
        },
        "location": {
          "name": "location",
          "type": "string",
          "editable": false
        },
        "athlete_type": {
          "name": "athlete_type",
          "type": "string",
          "editable": true,
          "values": [
            "Athlete",
            "Runner",
            "Marathoner",
            "Ultra Marathoner",
            "Cyclist",
            "Tri-Athlete",
            "Walker",
            "Hiker",
            "Skier",
            "Snowboarder",
            "Skater",
            "Swimmer",
            "Rower"
          ]
        },
        "goal": {
          "name": "goal",
          "type": "string",
          "editable": true
        },
        "gender": {
          "name": "gender",
          "type": "string",
          "editable": false,
          "values": [
            "M",
            "F"
          ]
        },
        "birthday": {
          "name": "birthday",
          "type": "datestring",
          "editable": false
        },
        "elite": {
          "name": "elite",
          "type": "boolean",
          "editable": false
        },
        "profile": {
          "name": "profile",
          "type": "string",
          "editable": false
        },
        "small_picture": {
          "name": "small_picture",
          "type": "string",
          "editable": false
        },
        "normal_picture": {
          "name": "normal_picture",
          "type": "string",
          "editable": false
        },
        "medium_picture": {
          "name": "medium_picture",
          "type": "string",
          "editable": false
        },
        "large_picture": {
          "name": "large_picture",
          "type": "string",
          "editable": false
        }
      }
    },
    "Settings": {
      "Name": "Settings",
      "Media_Type": "application/vnd.com.runkeeper.Settings+json",
      "Read": {
        "Method": "GET",
        "Url": "/settings"
      },
      "Update": {
        "Method": "PUT",
        "Url": "/settings"
      },
      "Fields": {
        "facebook_connected": {
          "name": "facebook_connected",
          "type": "boolean",
          "editable": false
        },
        "twitter_connected": {
          "name": "twitter_connected",
          "type": "boolean",
          "editable": false
        },
        "foursquare_connected": {
          "name": "foursquare_connected",
          "type": "boolean",
          "editable": false
        },
        "share_fitness_activities": {
          "name": "share_fitness_activities",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "share_map": {
          "name": "share_map",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_fitness_activity_facebook": {
          "name": "post_fitness_activity_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_fitness_activity_twitter": {
          "name": "post_fitness_activity_twitter",
          "type": "boolean",
          "editable": true
        },
        "post_live_fitness_activity_facebook": {
          "name": "post_live_fitness_activity_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_live_fitness_activity_twitter": {
          "name": "post_live_fitness_activity_twitter",
          "type": "boolean",
          "editable": true
        },
        "share_background_activities": {
          "name": "share_background_activities",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_background_activity_facebook": {
          "name": "post_background_activity_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_background_activity_twitter": {
          "name": "post_background_activity_twitter",
          "type": "boolean",
          "editable": true
        },
        "share_sleep": {
          "name": "share_sleep",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_sleep_facebook": {
          "name": "post_sleep_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_sleep_twitter": {
          "name": "post_sleep_twitter",
          "type": "boolean",
          "editable": true
        },
        "share_nutrition": {
          "name": "share_nutrition",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_nutrition_facebook": {
          "name": "post_nutrition_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_nutrition_twitter": {
          "name": "post_nutrition_twitter",
          "type": "boolean",
          "editable": true
        },
        "share_weight": {
          "name": "share_weight",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_weight_facebook": {
          "name": "post_weight_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_weight_twitter": {
          "name": "post_weight_twitter",
          "type": "boolean",
          "editable": true
        },
        "share_general_measurements": {
          "name": "share_general_measurements",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_general_measurements_facebook": {
          "name": "post_general_measurements_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_general_measurements_twitter": {
          "name": "post_general_measurements_twitter",
          "type": "boolean",
          "editable": true
        },
        "share_diabetes": {
          "name": "share_diabetes",
          "type": "string",
          "editable": true,
          "values": [
            "Just Me",
            "Street Team",
            "Everyone"
          ]
        },
        "post_diabetes_facebook": {
          "name": "post_diabetes_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_diabetes_twitter": {
          "name": "post_diabetes_twitter",
          "type": "boolean",
          "editable": true
        },
        "distance_units": {
          "name": "distance_units",
          "type": "string",
          "editable": true,
          "values": [
            "mi",
            "km"
          ]
        },
        "weight_units": {
          "name": "weight_units",
          "type": "string",
          "editable": true,
          "values": [
            "lbs",
            "kg"
          ]
        },
        "first_day_of_week": {
          "name": "first_day_of_week",
          "type": "string",
          "editable": true,
          "values": [
            "Sunday",
            "Monday"
          ]
        }
      }
    },
    "FitnessActivityFeed": {
      "Name": "FitnessActivityFeed",
      "Media_Type": "application/vnd.com.runkeeper.FitnessActivityFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/fitnessActivities",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "type": {
              "name": "type",
              "type": "string",
              "editable": "values",
              "values": [
                "Running",
                "Cycling",
                "Mountain Biking",
                "Walking",
                "Hiking",
                "Downhill Skiing",
                "Cross-Country Skiing",
                "Snowboarding",
                "Skating",
                "Swimming",
                "Wheelchair",
                "Rowing",
                "Elliptical",
                "Other"
              ]
            },
            "start_time": {
              "name": "start_time",
              "type": "datestring",
              "editable": false
            },
            "total_distance": {
              "name": "total_distance",
              "type": "float",
              "editable": false
            },
            "duration": {
              "name": "duration",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "FitnessActivity": {
      "Name": "FitnessActivity",
      "Media_Type": "application/vnd.com.runkeeper.FitnessActivity+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "type": {
          "name": "type",
          "type": "string",
          "editable": true,
          "values": [
            "Running",
            "Cycling",
            "Mountain Biking",
            "Walking",
            "Hiking",
            "Downhill Skiing",
            "Cross-Country Skiing",
            "Snowboarding",
            "Skating",
            "Swimming",
            "Wheelchair",
            "Rowing",
            "Elliptical",
            "Other"
          ]
        },
        "secondary_type": {
          "name": "secondary_type",
          "type": "string",
          "editable": true
        },
        "equipment": {
          "name": "equipment",
          "type": "string",
          "editable": true,
          "values": [
            "None",
            "Treadmill",
            "Stationary Bike",
            "Elliptical",
            "Row Machine"
          ]
        },
        "start_time": {
          "name": "start_time",
          "type": "datestring",
          "editable": false
        },
        "total_distance": {
          "name": "total_distance",
          "type": "float",
          "editable": true
        },
        "distance": {
          "name": "distance",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": false
            },
            "distance": {
              "name": "heart_rate",
              "type": "float",
              "editable": false
            }
          }
        },
        "duration": {
          "name": "duration",
          "type": "float",
          "editable": true
        },
        "average_heart_rate": {
          "name": "average_heart_rate",
          "type": "int",
          "editable": true
        },
        "heart_rate": {
          "name": "heart_rate",
          "type": "array",
          "editable": true,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": true
            },
            "heart_rate": {
              "name": "heart_rate",
              "type": "int",
              "editable": true
            }
          }
        },
        "total_calories": {
          "name": "total_calories",
          "type": "float",
          "editable": true
        },
        "calories": {
          "name": "calories",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": false
            },
            "calories": {
              "name": "heart_rate",
              "type": "float",
              "editable": false
            }
          }
        },
        "climb": {
          "name": "climb",
          "type": "float",
          "editable": false
        },
        "notes": {
          "name": "notes",
          "type": "string",
          "editable": true
        },
        "path": {
          "name": "path",
          "type": "array",
          "editable": true,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": true
            },
            "latitude": {
              "name": "latitude",
              "type": "float",
              "editable": true
            },
            "longitude": {
              "name": "longitude",
              "type": "float",
              "editable": true
            },
            "altitude": {
              "name": "altitude",
              "type": "float",
              "editable": true
            },
            "type": {
              "name": "type",
              "type": "string",
              "editable": true,
              "values": [
                "start",
                "end",
                "gps",
                "pause",
                "resume",
                "manual"
              ]
            }
          }
        },
        "images": {
          "name": "images",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": false
            },
            "latitude": {
              "name": "latitude",
              "type": "float",
              "editable": false
            },
            "longitude": {
              "name": "longitude",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            },
            "thumbnail_uri": {
              "name": "thumbnail_uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "activity": {
          "name": "activity",
          "type": "string",
          "editable": false
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewFitnessActivity": {
      "Name": "NewFitnessActivity",
      "Media_Type": "application/vnd.com.runkeeper.NewFitnessActivity+json",
      "Parent": "FitnessActivity",
      "Create": {
        "Method": "POST",
        "Url": "/fitnessActivities"
      },
      "Fields": {
        "type": {
          "name": "type",
          "type": "string",
          "editable": true,
          "values": [
            "Running",
            "Cycling",
            "Mountain Biking",
            "Walking",
            "Hiking",
            "Downhill Skiing",
            "Cross-Country Skiing",
            "Snowboarding",
            "Skating",
            "Swimming",
            "Wheelchair",
            "Rowing",
            "Elliptical",
            "Other"
          ]
        },
        "secondary_type": {
          "name": "secondary_type",
          "type": "string",
          "editable": true
        },
        "equipment": {
          "name": "equipment",
          "type": "string",
          "editable": true,
          "values": [
            "None",
            "Treadmill",
            "Stationary Bike",
            "Elliptical",
            "Row Machine"
          ]
        },
        "start_time": {
          "name": "start_time",
          "type": "datestring",
          "editable": true
        },
        "total_distance": {
          "name": "total_distance",
          "type": "float",
          "editable": true
        },
        "duration": {
          "name": "duration",
          "type": "float",
          "editable": true
        },
        "average_heart_rate": {
          "name": "average_heart_rate",
          "type": "int",
          "editable": true
        },
        "heart_rate": {
          "name": "heart_rate",
          "type": "array",
          "editable": true,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": true
            },
            "heart_rate": {
              "name": "heart_rate",
              "type": "int",
              "editable": true
            }
          }
        },
        "total_calories": {
          "name": "total_calories",
          "type": "float",
          "editable": true
        },
        "notes": {
          "name": "notes",
          "type": "string",
          "editable": true
        },
        "path": {
          "name": "path",
          "type": "array",
          "editable": true,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": true
            },
            "latitude": {
              "name": "latitude",
              "type": "float",
              "editable": true
            },
            "longitude": {
              "name": "longitude",
              "type": "float",
              "editable": true
            },
            "altitude": {
              "name": "altitude",
              "type": "float",
              "editable": true
            },
            "type": {
              "name": "type",
              "type": "string",
              "editable": true,
              "values": [
                "start",
                "end",
                "gps",
                "pause",
                "resume",
                "manual"
              ]
            }
          }
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        },
        "detect_pauses": {
          "name": "detect_pauses",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "LiveFitnessActivity": {
      "Name": "LiveFitnessActivity",
      "Media_Type": "application/vnd.com.runkeeper.LiveFitnessActivity+json",
      "Parent": "FitnessActivity",
      "Create": {
        "Method": "POST",
        "Url": "/fitnessActivities"
      },
      "Fields": {
        "type": {
          "name": "type",
          "type": "string",
          "editable": true,
          "values": [
            "Running",
            "Cycling",
            "Mountain Biking",
            "Walking",
            "Hiking",
            "Downhill Skiing",
            "Cross-Country Skiing",
            "Snowboarding",
            "Skating",
            "Swimming",
            "Wheelchair",
            "Rowing",
            "Elliptical",
            "Other"
          ]
        },
        "secondary_type": {
          "name": "secondary_type",
          "type": "string",
          "editable": true
        },
        "equipment": {
          "name": "equipment",
          "type": "string",
          "editable": true,
          "values": [
            "None",
            "Treadmill",
            "Stationary Bike",
            "Elliptical",
            "Row Machine"
          ]
        },
        "start_time": {
          "name": "start_time",
          "type": "datestring",
          "editable": true
        }
      }
    },
    "LiveFitnessActivityUpdate": {
      "Name": "LiveFitnessActivityUpdate",
      "Media_Type": "application/vnd.com.runkeeper.LiveFitnessActivityUpdate+json",
      "Update": {
        "Method": "POST"
      },
      "Fields": {
        "heart_rate": {
          "name": "heart_rate",
          "type": "array",
          "editable": true,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": true
            },
            "heart_rate": {
              "name": "heart_rate",
              "type": "int",
              "editable": true
            }
          }
        },
        "path": {
          "name": "path",
          "type": "array",
          "editable": true,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "float",
              "editable": true
            },
            "latitude": {
              "name": "latitude",
              "type": "float",
              "editable": true
            },
            "longitude": {
              "name": "longitude",
              "type": "float",
              "editable": true
            },
            "altitude": {
              "name": "altitude",
              "type": "float",
              "editable": true
            },
            "type": {
              "name": "type",
              "type": "string",
              "editable": true,
              "values": [
                "start",
                "end",
                "gps",
                "pause",
                "resume",
                "manual"
              ]
            }
          }
        }
      }
    },
    "LiveFitnessActivityCompletion": {
      "Name": "LiveFitnessActivityCompletion",
      "Media_Type": "application/vnd.com.runkeeper.LiveFitnessActivityCompletion+json",
      "Update": {
        "Method": "POST"
      },
      "Fields": {
        "notes": {
          "name": "notes",
          "type": "string",
          "editable": true
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        },
        "detect_pauses": {
          "name": "detect_pauses",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "StrengthTrainingActivityFeed": {
      "Name": "StrengthTrainingActivityFeed",
      "Media_Type": "application/vnd.com.runkeeper.StrengthTrainingActivityFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/strengthTrainingActivities",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "start_time": {
              "name": "start_time",
              "type": "datestring",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "StrengthTrainingActivity": {
      "Name": "StrengthTrainingActivity",
      "Media_Type": "application/vnd.com.runkeeper.StrengthTrainingActivity+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "start_time": {
          "name": "start_time",
          "type": "datestring",
          "editable": false
        },
        "notes": {
          "name": "notes",
          "type": "string",
          "editable": true
        },
        "exercices": {
          "name": "exercices",
          "type": "array",
          "editable": true,
          "Fields": {
            "primary_type": {
              "name": "primary_type",
              "type": "string",
              "editable": true,
              "values": [
                "Barbell Curl",
                "Dumbbell Curl",
                "Barbell Tricep Press",
                "Dumbbell Tricep Press",
                "Overhead Press",
                "Wrist Curl",
                "Tricep Kickback",
                "Bench Press",
                "Cable Crossover",
                "Dumbbell Fly",
                "Incline Bench",
                "Dips",
                "Pushup",
                "Pullup",
                "Back Raise",
                "Bent-Over Row",
                "Seated Row",
                "Chinup",
                "Lat Pulldown",
                "Seated Reverse Fly",
                "Military Press",
                "Upright Row",
                "Front Raise",
                "Side Lateral Raise",
                "Snatch",
                "Push Press",
                "Shrug",
                "Crunch Machine",
                "Crunch",
                "Ab Twist",
                "Bicycle Kick",
                "Hanging Leg Raise",
                "Hanging Knee Raise",
                "Reverse Crunch",
                "V Up",
                "Situp",
                "Squat",
                "Lunge",
                "Dead Lift",
                "Hamstring Curl",
                "Good Morning",
                "Clean",
                "Leg Press",
                "Leg Extension",
                "Other"
              ]
            },
            "secondary_type": {
              "name": "secondary_type",
              "type": "string",
              "editable": true
            },
            "primary_muscle_group": {
              "name": "primary_muscle_group",
              "type": "string",
              "editable": true,
              "values": [
                "Arms",
                "Chest",
                "Back",
                "Shoulders",
                "Abs",
                "Legs"
              ]
            },
            "secondary_muscle_group": {
              "name": "secondary_muscle_group",
              "type": "string",
              "editable": true,
              "values": [
                "Arms",
                "Chest",
                "Back",
                "Shoulders",
                "Abs",
                "Legs"
              ]
            },
            "routine": {
              "name": "routine",
              "type": "string",
              "editable": true
            },
            "notes": {
              "name": "notes",
              "type": "string",
              "editable": true
            },
            "sets": {
              "name": "sets",
              "type": "array",
              "editable": true,
              "Fields": {
                "weight": {
                  "name": "weight",
                  "type": "float",
                  "editable": true
                },
                "repetitions": {
                  "name": "repetitions",
                  "type": "int",
                  "editable": true
                },
                "notes": {
                  "name": "notes",
                  "type": "string",
                  "editable": true
                }
              }
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewStrengthTrainingActivity": {
      "Name": "NewStrengthTrainingActivity",
      "Media_Type": "application/vnd.com.runkeeper.NewStrengthTrainingActivity+json",
      "Parent": "SrengthTrainingActivity",
      "Create": {
        "Method": "POST",
        "Url": "/strengthTrainingActivities"
      },
      "Fields": {
        "start_time": {
          "name": "start_time",
          "type": "datestring",
          "editable": false
        },
        "notes": {
          "name": "notes",
          "type": "string",
          "editable": true
        },
        "exercices": {
          "name": "exercices",
          "type": "array",
          "editable": true,
          "Fields": {
            "primary_type": {
              "name": "primary_type",
              "type": "string",
              "editable": true,
              "values": [
                "Barbell Curl",
                "Dumbbell Curl",
                "Barbell Tricep Press",
                "Dumbbell Tricep Press",
                "Overhead Press",
                "Wrist Curl",
                "Tricep Kickback",
                "Bench Press",
                "Cable Crossover",
                "Dumbbell Fly",
                "Incline Bench",
                "Dips",
                "Pushup",
                "Pullup",
                "Back Raise",
                "Bent-Over Row",
                "Seated Row",
                "Chinup",
                "Lat Pulldown",
                "Seated Reverse Fly",
                "Military Press",
                "Upright Row",
                "Front Raise",
                "Side Lateral Raise",
                "Snatch",
                "Push Press",
                "Shrug",
                "Crunch Machine",
                "Crunch",
                "Ab Twist",
                "Bicycle Kick",
                "Hanging Leg Raise",
                "Hanging Knee Raise",
                "Reverse Crunch",
                "V Up",
                "Situp",
                "Squat",
                "Lunge",
                "Dead Lift",
                "Hamstring Curl",
                "Good Morning",
                "Clean",
                "Leg Press",
                "Leg Extension",
                "Other"
              ]
            },
            "secondary_type": {
              "name": "secondary_type",
              "type": "string",
              "editable": true
            },
            "primary_muscle_group": {
              "name": "primary_muscle_group",
              "type": "string",
              "editable": true,
              "values": [
                "Arms",
                "Chest",
                "Back",
                "Shoulders",
                "Abs",
                "Legs"
              ]
            },
            "secondary_muscle_group": {
              "name": "secondary_muscle_group",
              "type": "string",
              "editable": true,
              "values": [
                "Arms",
                "Chest",
                "Back",
                "Shoulders",
                "Abs",
                "Legs"
              ]
            },
            "routine": {
              "name": "routine",
              "type": "string",
              "editable": true
            },
            "notes": {
              "name": "notes",
              "type": "string",
              "editable": true
            },
            "sets": {
              "name": "sets",
              "type": "array",
              "editable": true,
              "Fields": {
                "weight": {
                  "name": "weight",
                  "type": "float",
                  "editable": true
                },
                "repetitions": {
                  "name": "repetitions",
                  "type": "int",
                  "editable": true
                },
                "notes": {
                  "name": "notes",
                  "type": "string",
                  "editable": true
                }
              }
            }
          }
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "BackgroundActivityFeed": {
      "Name": "BackgroundActivityFeed",
      "Media_Type": "application/vnd.com.runkeeper.BackgroundActivityFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/backgroundActivities",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "datestring",
              "editable": false
            },
            "calories_burned": {
              "name": "calories_burned",
              "type": "float",
              "editable": false
            },
            "steps": {
              "name": "steps",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "BackgroundActivity": {
      "Name": "BackgroundActivity",
      "Media_Type": "application/vnd.com.runkeeper.BackgroundActivity+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "calories_burned": {
          "name": "calories_burned",
          "type": "float",
          "editable": false
        },
        "steps": {
          "name": "steps",
          "type": "float",
          "editable": false
        },
        "notes": {
          "name": "notes",
          "type": "string",
          "editable": true
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewBackgroundActivity": {
      "Name": "NewBackgroundActivity",
      "Media_Type": "application/vnd.com.runkeeper.NewBackgroundActivity+json",
      "Parent": "BackgroundActivity",
      "Create": {
        "Method": "POST",
        "Url": "/backgroundActivities"
      },
      "Fields": {
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "calories_burned": {
          "name": "calories_burned",
          "type": "float",
          "editable": false
        },
        "steps": {
          "name": "steps",
          "type": "float",
          "editable": false
        }
      }
    },
    "SleepFeed": {
      "Name": "SleepFeed",
      "Media_Type": "application/vnd.com.runkeeper.SleepFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/sleep",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "datestring",
              "editable": false
            },
            "total_sleep": {
              "name": "total_sleep",
              "type": "float",
              "editable": false
            },
            "rem": {
              "name": "rem",
              "type": "float",
              "editable": false
            },
            "deep": {
              "name": "deep",
              "type": "float",
              "editable": false
            },
            "light": {
              "name": "light",
              "type": "float",
              "editable": false
            },
            "times_woken": {
              "name": "times_woken",
              "type": "float",
              "editable": false
            },
            "awake": {
              "name": "awake",
              "type": "string",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "Sleep": {
      "Name": "Sleep",
      "Media_Type": "application/vnd.com.runkeeper.Sleep+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "total_sleep": {
          "name": "total_sleep",
          "type": "float",
          "editable": false
        },
        "rem": {
          "name": "rem",
          "type": "float",
          "editable": false
        },
        "deep": {
          "name": "deep",
          "type": "float",
          "editable": false
        },
        "light": {
          "name": "light",
          "type": "float",
          "editable": false
        },
        "times_woken": {
          "name": "times_woken",
          "type": "float",
          "editable": false
        },
        "awake": {
          "name": "awake",
          "type": "string",
          "editable": false
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewSleep": {
      "Name": "NewSleep",
      "Media_Type": "application/vnd.com.runkeeper.NewSleep+json",
      "Parent": "Sleep",
      "Create": {
        "Method": "POST",
        "Url": "/sleep"
      },
      "Fields": {
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "total_sleep": {
          "name": "total_sleep",
          "type": "float",
          "editable": false
        },
        "rem": {
          "name": "rem",
          "type": "float",
          "editable": false
        },
        "deep": {
          "name": "deep",
          "type": "float",
          "editable": false
        },
        "light": {
          "name": "light",
          "type": "float",
          "editable": false
        },
        "times_woken": {
          "name": "times_woken",
          "type": "float",
          "editable": false
        },
        "awake": {
          "name": "awake",
          "type": "string",
          "editable": false
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "NutritionFeed": {
      "Name": "NutritionFeed",
      "Media_Type": "application/vnd.com.runkeeper.NutritionFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/nutrition",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "datestring",
              "editable": false
            },
            "calories": {
              "name": "calories",
              "type": "float",
              "editable": false
            },
            "carbohydrates": {
              "name": "carbohydrates",
              "type": "float",
              "editable": false
            },
            "fat": {
              "name": "fat",
              "type": "float",
              "editable": false
            },
            "fiber": {
              "name": "fiber",
              "type": "float",
              "editable": false
            },
            "protein": {
              "name": "protein",
              "type": "float",
              "editable": false
            },
            "sodium": {
              "name": "sodium",
              "type": "float",
              "editable": false
            },
            "water": {
              "name": "water",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "Nutrition": {
      "Name": "Nutrition",
      "Media_Type": "application/vnd.com.runkeeper.Nutrition+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "calories": {
          "name": "calories",
          "type": "float",
          "editable": false
        },
        "carbohydrates": {
          "name": "carbohydrates",
          "type": "float",
          "editable": false
        },
        "fat": {
          "name": "fat",
          "type": "float",
          "editable": false
        },
        "fiber": {
          "name": "fiber",
          "type": "float",
          "editable": false
        },
        "protein": {
          "name": "protein",
          "type": "float",
          "editable": false
        },
        "sodium": {
          "name": "sodium",
          "type": "float",
          "editable": false
        },
        "water": {
          "name": "water",
          "type": "float",
          "editable": false
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewNutrition": {
      "Name": "NewNutrition",
      "Media_Type": "application/vnd.com.runkeeper.NewNutrition+json",
      "Parent": "Nutrition",
      "Create": {
        "Method": "POST",
        "Url": "/nutrition"
      },
      "Fields": {
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "calories": {
          "name": "calories",
          "type": "float",
          "editable": false
        },
        "carbohydrates": {
          "name": "carbohydrates",
          "type": "float",
          "editable": false
        },
        "fat": {
          "name": "fat",
          "type": "float",
          "editable": false
        },
        "fiber": {
          "name": "fiber",
          "type": "float",
          "editable": false
        },
        "protein": {
          "name": "protein",
          "type": "float",
          "editable": false
        },
        "sodium": {
          "name": "sodium",
          "type": "float",
          "editable": false
        },
        "water": {
          "name": "water",
          "type": "float",
          "editable": false
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "WeightFeed": {
      "Name": "WeightFeed",
      "Media_Type": "application/vnd.com.runkeeper.WeightFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/weight",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "datestring",
              "editable": false
            },
            "weight": {
              "name": "weight",
              "type": "float",
              "editable": false
            },
            "free_mass": {
              "name": "free_mass",
              "type": "float",
              "editable": false
            },
            "mass_weight": {
              "name": "mass_weight",
              "type": "float",
              "editable": false
            },
            "fat_percent": {
              "name": "fat_percent",
              "type": "float",
              "editable": false
            },
            "bmi": {
              "name": "bmi",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "Weight": {
      "Name": "Weight",
      "Media_Type": "application/vnd.com.runkeeper.Weight+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "weight": {
          "name": "weight",
          "type": "float",
          "editable": false
        },
        "free_mass": {
          "name": "free_mass",
          "type": "float",
          "editable": false
        },
        "mass_weight": {
          "name": "mass_weight",
          "type": "float",
          "editable": false
        },
        "fat_percent": {
          "name": "fat_percent",
          "type": "float",
          "editable": false
        },
        "bmi": {
          "name": "bmi",
          "type": "float",
          "editable": false
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewWeight": {
      "Name": "NewWeight",
      "Media_Type": "application/vnd.com.runkeeper.NewWeight+json",
      "Parent": "Weight",
      "Create": {
        "Method": "POST",
        "Url": "/weight"
      },
      "Fields": {
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "weight": {
          "name": "weight",
          "type": "float",
          "editable": false
        },
        "free_mass": {
          "name": "free_mass",
          "type": "float",
          "editable": false
        },
        "mass_weight": {
          "name": "mass_weight",
          "type": "float",
          "editable": false
        },
        "fat_percent": {
          "name": "fat_percent",
          "type": "float",
          "editable": false
        },
        "bmi": {
          "name": "bmi",
          "type": "float",
          "editable": false
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "GeneralMeasurementFeed": {
      "Name": "GeneralMeasurementFeed",
      "Media_Type": "application/vnd.com.runkeeper.GeneralMeasurementFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/generalMeasurements",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "datestring",
              "editable": false
            },
            "vitamin_d": {
              "name": "vitamin_d",
              "type": "float",
              "editable": false
            },
            "hscrp": {
              "name": "hscrp",
              "type": "float",
              "editable": false
            },
            "crp": {
              "name": "crp",
              "type": "float",
              "editable": false
            },
            "tsh": {
              "name": "tsh",
              "type": "float",
              "editable": false
            },
            "uric_acid": {
              "name": "uric_acid",
              "type": "float",
              "editable": false
            },
            "systolic": {
              "name": "systolic",
              "type": "float",
              "editable": false
            },
            "diastolic": {
              "name": "diastolic",
              "type": "float",
              "editable": false
            },
            "resting_heartrate": {
              "name": "resting_heartrate",
              "type": "float",
              "editable": false
            },
            "total_cholesterol": {
              "name": "total_cholesterol",
              "type": "float",
              "editable": false
            },
            "hdl": {
              "name": "hdl",
              "type": "float",
              "editable": false
            },
            "ldl": {
              "name": "ldl",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "GeneralMeasurement": {
      "Name": "GeneralMeasurement",
      "Media_Type": "application/vnd.com.runkeeper.GeneralMeasurement+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "vitamin_d": {
          "name": "vitamin_d",
          "type": "float",
          "editable": false
        },
        "hscrp": {
          "name": "hscrp",
          "type": "float",
          "editable": false
        },
        "crp": {
          "name": "crp",
          "type": "float",
          "editable": false
        },
        "tsh": {
          "name": "tsh",
          "type": "float",
          "editable": false
        },
        "uric_acid": {
          "name": "uric_acid",
          "type": "float",
          "editable": false
        },
        "systolic": {
          "name": "systolic",
          "type": "float",
          "editable": false
        },
        "diastolic": {
          "name": "diastolic",
          "type": "float",
          "editable": false
        },
        "resting_heartrate": {
          "name": "resting_heartrate",
          "type": "float",
          "editable": false
        },
        "total_cholesterol": {
          "name": "total_cholesterol",
          "type": "float",
          "editable": false
        },
        "hdl": {
          "name": "hdl",
          "type": "float",
          "editable": false
        },
        "ldl": {
          "name": "ldl",
          "type": "float",
          "editable": false
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_diabetes {name": "nearest_diabetes, type: string, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewGeneralMeasurement": {
      "Name": "NewGeneralMeasurement",
      "Media_Type": "application/vnd.com.runkeeper.NewGeneralMeasurement+json",
      "Parent": "GeneralMeasurement",
      "Create": {
        "Method": "POST",
        "Url": "/generalMeasurements"
      },
      "Fields": {
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "vitamin_d": {
          "name": "vitamin_d",
          "type": "float",
          "editable": false
        },
        "hscrp": {
          "name": "hscrp",
          "type": "float",
          "editable": false
        },
        "crp": {
          "name": "crp",
          "type": "float",
          "editable": false
        },
        "tsh": {
          "name": "tsh",
          "type": "float",
          "editable": false
        },
        "uric_acid": {
          "name": "uric_acid",
          "type": "float",
          "editable": false
        },
        "systolic": {
          "name": "systolic",
          "type": "float",
          "editable": false
        },
        "diastolic": {
          "name": "diastolic",
          "type": "float",
          "editable": false
        },
        "resting_heartrate": {
          "name": "resting_heartrate",
          "type": "float",
          "editable": false
        },
        "total_cholesterol": {
          "name": "total_cholesterol",
          "type": "float",
          "editable": false
        },
        "hdl": {
          "name": "hdl",
          "type": "float",
          "editable": false
        },
        "ldl": {
          "name": "ldl",
          "type": "float",
          "editable": false
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "DiabetesFeed": {
      "Name": "DiabetesFeed",
      "Media_Type": "application/vnd.com.runkeeper.DiabetesFeed+json",
      "Read": {
        "Method": "GET",
        "Url": "/diabetes",
        "OptionalParameters": {
          "page": {
            "type": "int",
            "default": 1
          },
          "pageSize": {
            "type": "int",
            "default": 25
          },
          "noEarlierThan": {
            "type": "date"
          },
          "noLaterThan": {
            "type": "date"
          },
          "modifiedNoEarlierThan": {
            "type": "date"
          },
          "modifiedNoLaterThan": {
            "type": "date"
          }
        }
      },
      "Fields": {
        "size": {
          "name": "size",
          "type": "int",
          "editable": false
        },
        "items": {
          "name": "items",
          "type": "array",
          "editable": false,
          "Fields": {
            "timestamp": {
              "name": "timestamp",
              "type": "datestring",
              "editable": false
            },
            "fasting_plasma_glucose_test": {
              "name": "fasting_plasma_glucose_test",
              "type": "float",
              "editable": false
            },
            "random_plasma_glucose_test": {
              "name": "random_plasma_glucose_test",
              "type": "float",
              "editable": false
            },
            "oral_glucose_tolerance_test": {
              "name": "oral_glucose_tolerance_test",
              "type": "float",
              "editable": false
            },
            "hemoglobin_a1c": {
              "name": "hemoglobin_a1c",
              "type": "float",
              "editable": false
            },
            "insulin": {
              "name": "insulin",
              "type": "float",
              "editable": false
            },
            "c_peptide": {
              "name": "c_peptide",
              "type": "float",
              "editable": false
            },
            "triglyceride": {
              "name": "triglyceride",
              "type": "float",
              "editable": false
            },
            "uri": {
              "name": "uri",
              "type": "string",
              "editable": false
            }
          }
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        }
      }
    },
    "DiabetesMeasurement": {
      "Name": "DiabetesMeasurement",
      "Media_Type": "application/vnd.com.runkeeper.DiabetesMeasurement+json",
      "Read": {
        "Method": "GET"
      },
      "Update": {
        "Method": "PUT"
      },
      "Delete": {
        "Method": "DELETE"
      },
      "Fields": {
        "uri": {
          "name": "uri",
          "type": "string",
          "editable": false
        },
        "userID": {
          "name": "userID",
          "type": "int",
          "editable": false
        },
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "fasting_plasma_glucose_test": {
          "name": "fasting_plasma_glucose_test",
          "type": "float",
          "editable": false
        },
        "random_plasma_glucose_test": {
          "name": "random_plasma_glucose_test",
          "type": "float",
          "editable": false
        },
        "oral_glucose_tolerance_test": {
          "name": "oral_glucose_tolerance_test",
          "type": "float",
          "editable": false
        },
        "hemoglobin_a1c": {
          "name": "hemoglobin_a1c",
          "type": "float",
          "editable": false
        },
        "insulin": {
          "name": "insulin",
          "type": "float",
          "editable": false
        },
        "c_peptide": {
          "name": "c_peptide",
          "type": "float",
          "editable": false
        },
        "triglyceride": {
          "name": "triglyceride",
          "type": "float",
          "editable": false
        },
        "previous": {
          "name": "previous",
          "type": "string",
          "editable": false
        },
        "next": {
          "name": "next",
          "type": "string",
          "editable": false
        },
        "nearest_fitness_activity {name": "nearest_fitness_activity, type: string, editable: false}",
        "nearest_teammate_fitness_activities {name": "nearest_teammate_fitness_activities, type: array, editable: false}",
        "nearest_strength_training_activity {name": "nearest_strength_training_activity, type: string, editable: false}",
        "nearest_teammate_strength_training_activities {name": "nearest_teammate_strength_training_activities, type: array, editable: false}",
        "nearest_background_activity {name": "nearest_background_activity, type: string, editable: false}",
        "nearest_teammate_background_activities {name": "nearest_teammate_background_activities, type: array, editable: false}",
        "nearest_sleep {name": "nearest_sleep, type: string, editable: false}",
        "nearest_teammate_sleep {name": "nearest_teammate_sleep, type: array, editable: false}",
        "nearest_nutrition {name": "nearest_nutrition, type: string, editable: false}",
        "nearest_teammate_nutrition {name": "nearest_teammate_nutrition, type: array, editable: false}",
        "nearest_weight {name": "nearest_weight, type: string, editable: false}",
        "nearest_teammate_weight {name": "nearest_teammate_weight, type: array, editable: false}",
        "nearest_general_measurement {name": "nearest_general_measurement_activity, type: string, editable: false}",
        "nearest_teammate_general_measurements_training_activities {name": "nearest_teammate_general_measurements, type: array, editable: false}",
        "nearest_teammate_diabetes {name": "nearest_teammate_diabetes, type: array, editable: false}"
      }
    },
    "NewDiabetesMeasurement": {
      "Name": "NewDiabetesMeasurement",
      "Media_Type": "application/vnd.com.runkeeper.NewDiabetesMeasurement+json",
      "Parent": "DiabetesMeasurement",
      "Create": {
        "Method": "POST",
        "Url": "/diabetes"
      },
      "Fields": {
        "timestamp": {
          "name": "timestamp",
          "type": "datestring",
          "editable": false
        },
        "fasting_plasma_glucose_test": {
          "name": "fasting_plasma_glucose_test",
          "type": "float",
          "editable": false
        },
        "random_plasma_glucose_test": {
          "name": "random_plasma_glucose_test",
          "type": "float",
          "editable": false
        },
        "oral_glucose_tolerance_test": {
          "name": "oral_glucose_tolerance_test",
          "type": "float",
          "editable": false
        },
        "hemoglobin_a1c": {
          "name": "hemoglobin_a1c",
          "type": "float",
          "editable": false
        },
        "insulin": {
          "name": "insulin",
          "type": "float",
          "editable": false
        },
        "c_peptide": {
          "name": "c_peptide",
          "type": "float",
          "editable": false
        },
        "triglyceride": {
          "name": "triglyceride",
          "type": "float",
          "editable": false
        },
        "post_to_facebook": {
          "name": "post_to_facebook",
          "type": "boolean",
          "editable": true
        },
        "post_to_twitter": {
          "name": "post_to_twitter",
          "type": "boolean",
          "editable": true
        }
      }
    },
    "Records": {
      "Name": "Records",
      "Media_Type": "application/vnd.com.runkeeper.Records+json",
      "Read": {
        "Method": "GET",
        "Url": "/records"
      },
      "Fields": {
        "activity_type": {
          "name": "activity_type",
          "type": "string",
          "editable": false
        },
        "stats": {
          "name": "stats",
          "type": "array",
          "editable": false
        }
      }
    }
  }
}'; 

	/**
	 * Build a new instnace of RunKeeperAPI
	 *
	 * @param string $api_conf_file Path to the configuration file
	 */
	public function __construct($client_id,$client_secret,$auth_url) {
	   /*i have done some modifications to make compatible some functions for stportsnet.es*/
       
				$this->api_conf = json_decode($this->config);
				$this->client_id = $client_id;
				$this->client_secret = $client_secret;
				$this->auth_url = $auth_url;
				$this->access_token_url = $this->api_conf->App->access_token_url;
				$this->redirect_uri = $this->api_conf->App->redirect_uri;
				$this->api_base_url = $this->api_conf->App->api_base_url;
				$this->api_created = true;

	}

	/**
	 * Get the URL for the login button
	 *
	 * @return string
	 */
	public function connectRunkeeperButtonUrl () {
		$url = $this->auth_url.'?response_type=code&client_id='.$this->client_id.'&redirect_uri='.urlencode($this->redirect_uri);
		return($url);
	}

	/**
	 * Get the token from the authorization code
	 *
	 * @param string $authorization_code
	 * @param string $redirect_uri
	 *
	 * @return string
	 */
	public function getRunkeeperToken ($authorization_code, $redirect_uri='') {
		$params = http_build_query(array(
			'grant_type'	=>	'authorization_code',
			'code'		=>	$authorization_code,
			'client_id'	=>	$this->client_id,
			'client_secret'	=>	$this->client_secret,
			'redirect_uri'	=>	($redirect_uri == '' ? $this->redirect_uri : $redirect_uri)
		));
		$options = array(
			CURLOPT_URL		=>	$this->access_token_url,
			CURLOPT_POST		=>	true,
			CURLOPT_POSTFIELDS	=>	$params,
			CURLOPT_RETURNTRANSFER	=>	true
		);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); /* Added to avoid "error :SSL certificate problem, verify that the CA cert is OK" */
		curl_setopt_array($curl, $options);
		$response     = curl_exec($curl);
		curl_close($curl);
		$decoderesponse = json_decode($response);
        
		if ($decoderesponse == null) {
			$this->api_last_error = "getRunkeeperToken: bad response";
			return(false);
		}
		elseif (!isset($decoderesponse->error)) {
			if (isset($decoderesponse->access_token)) {
				$this->access_token = $decoderesponse->access_token;
			}
			if (isset($decoderesponse->token_type)) {
				$this->token_type = $decoderesponse->token_type;
			}
			return(array($this->access_token,$this->token_type));
		}
		elseif ($decoderesponse->error == 'invalid_grant') {
		  
          $a = $this->auth_url.'?response_type=code&client_id='.$this->client_id.'&redirect_uri='.urlencode($this->redirect_uri);
          echo "error al obtener el token, por favor cierre sesion en su cuenta de runkeeper y vuelva a intentar haciendo click <a href='$a' >aqui</a>  ";
          exit();
		}
		else {
			$this->api_last_error = "getRunkeeperToken: ".$decoderesponse->error;
			return(false);

		}
	}

	/**
	 * Set the token to use
	 *
	 * @param string $access_token
	 */
	public function setRunkeeperToken ($access_token) {
		$this->access_token = $access_token;
	}

	/**
	 * Do a request on the API
	 *
	 * @param string $name
	 * @param string $type
	 * @param array  $fields
	 * @param string $url
	 * @param array  $optparams
	 *
	 * @return array
	 */
	public function doRunkeeperRequest($name, $type, $fields=null, $url=null, $optparams=null) {
		$this->requestRedirectUrl = null;
		$orig = microtime(true);
		if (empty($name) || !isset($this->api_conf->Interfaces->$name)) {
			$this->api_last_error = "doRunkeeperRequest: wrong or missing Interface name : " . $name;
			return(false);
		}
		elseif (!$type || !isset($this->api_conf->Interfaces->$name->$type)) {
			$this->api_last_error = "doRunkeeperRequest: not supported or missing type (Read, Update, Create or Delete)";
            return(false);
		}
		else {	  
    
			switch($this->api_conf->Interfaces->$name->$type->Method) {
				case 'GET':
					$params = ($optparams == null ? '' : '?'.http_build_query($optparams));
					$options = array(
						CURLOPT_HTTPHEADER	=>	array(
							'Authorization: '.$this->token_type.' '.$this->access_token,
							'Accept: '.$this->api_conf->Interfaces->$name->Media_Type
							),
						CURLOPT_URL		=>	($url == null ? $this->api_base_url.$this->api_conf->Interfaces->$name->$type->Url : (strstr($url,'http://') || strstr($url,'https://') ? $url : $this->api_base_url.$url)).$params,
						CURLOPT_RETURNTRANSFER	=>	true,
						CURLINFO_HEADER_OUT	=>	true,
					);
					break;
				case 'POST':
					$params = ($optparams == null ? '' : '?'.http_build_query($optparams));
					$jsonfields = json_encode($fields);
					$options = array(
						CURLOPT_HTTPHEADER	=>	array(
							'Authorization: '.$this->token_type.' '.$this->access_token,
							'Content-Type: '.$this->api_conf->Interfaces->$name->Media_Type,
							'Content-Length: '.strlen($jsonfields)
							),
						CURLOPT_FOLLOWLOCATION	=>	false,
						CURLOPT_URL		=>	($url == null ? $this->api_base_url.$this->api_conf->Interfaces->$name->$type->Url : (strstr($url,'http://') || strstr($url,'https://') ? $url : $this->api_base_url.$url)).$params,
						CURLOPT_RETURNTRANSFER	=>	true,
						CURLINFO_HEADER_OUT	=>	true,
						CURLOPT_CUSTOMREQUEST	=>	'POST',
						CURLOPT_POSTFIELDS	=>	$jsonfields
					);
					break;
				case 'PUT':
					$params = ($optparams == null ? '' : '?'.http_build_query($optparams));
					$jsonfields = json_encode($fields);
					$options = array(
						CURLOPT_HTTPHEADER	=>	array(
							'Authorization: '.$this->token_type.' '.$this->access_token,
							'Content-Type: '.$this->api_conf->Interfaces->$name->Media_Type,
							'Content-Length: '.strlen($jsonfields)
							),
						CURLOPT_FOLLOWLOCATION	=>	false,
						CURLOPT_URL		=>	($url == null ? $this->api_base_url.$this->api_conf->Interfaces->$name->$type->Url : (strstr($url,'http://') || strstr($url,'https://') ? $url : $this->api_base_url.$url)).$params,
						CURLOPT_RETURNTRANSFER	=>	true,
						CURLINFO_HEADER_OUT	=>	true,
						CURLOPT_CUSTOMREQUEST	=>	'PUT',
						CURLOPT_POSTFIELDS	=>	$jsonfields
					);
					break;
				case 'DELETE':
					$options = array(
						CURLOPT_HTTPHEADER	=>	array(
							'Authorization: '.$this->token_type.' '.$this->access_token,
							'Content-Type: '.$this->api_conf->Interfaces->$name->Media_Type,
							'Content-Length: 0'
							),
						CURLOPT_FOLLOWLOCATION	=>	false,
						CURLOPT_URL		=>	($url == null ? $this->api_base_url.$this->api_conf->Interfaces->$name->$type->Url : (strstr($url,'http://') || strstr($url,'https://') ? $url : $this->api_base_url.$url)).$params,
						CURLOPT_RETURNTRANSFER	=>	true,
						CURLINFO_HEADER_OUT	=>	true,
						CURLOPT_CUSTOMREQUEST	=>	'PUT'
					);

					break;
			}
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); /* Added to avoid "error :SSL certificate problem, verify that the CA cert is OK" */
			curl_setopt_array($curl, $options);
			curl_setopt($curl, CURLOPT_HEADERFUNCTION, array(&$this,'parseHeader')); /* add callback header function to process response headers */
			$response     = curl_exec($curl);
			$responsecode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
			curl_close($curl);
			if ($this->requestRedirectUrl != null) {
				/* After creating new activity/measurement : get a Location header with url to retreive created activity/measurment */
				$parentName = (!property_exists($this->api_conf->Interfaces->$name,'Parent') ? $this->api_conf->Interfaces->$name->Name : $this->api_conf->Interfaces->$name->Parent);
				$this->api_request_log[] = array('name' => $name, 'type' => $type, 'result' => 'redir', 'time' => microtime(true)-$orig);
				return $this->doRunkeeperRequest($parentName,'Read',$fields,$this->requestRedirectUrl,$optparams);
			}
			else {
				if ($responsecode === 200) {
					$response = htmlentities($response,ENT_NOQUOTES);
					$decoderesponse = json_decode($response);
					$this->api_request_log[] = array('name' => $name, 'type' => $type, 'result' => 200, 'responsecode' => $responsecode, 'time' => microtime(true)-$orig);
					return($decoderesponse);
				}

				elseif (in_array($responsecode, array('201','204','301','304'))) {
					$this->api_request_log[] = array('name' => $name, 'type' => $type, 'result' => $responsecode, 'responsecode' => $responsecode, 'time' => microtime(true)-$orig);
					return true;
				}
				else {
					$this->api_last_error = "doRunkeeperRequest: request error => 'name' : ".$name.", 'type' : ".$type.", 'result' : ".$responsecode.", '".$name."' => ".$url;
					$this->api_request_log[] = array('name' => $name, 'type' => $type, 'result' => 'error : '.$responsecode, 'responsecode' => $responsecode, 'time' => microtime(true)-$orig);
					return false;
				}
			}
		}
	}

	/**
	 * Parse an header
	 *
	 * @param resource $curl
	 * @param string $header
	 *
	 * @return integer
	 */
	private function parseHeader ($curl, $header) {
		if (strstr($header,'Location: ')) {
			$this->requestRedirectUrl = substr($header, 10, strlen($header)-12);
		}

		return strlen($header);
	}
}
?>
