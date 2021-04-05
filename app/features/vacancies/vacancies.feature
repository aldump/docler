Feature: Receiving vacancies

  Scenario: Check that end-point returning vacancies
    When I request "/api/vacancy"
    Then the response code is 200
    And the response body is a JSON array with a length of at least 1

  Scenario: Check that end-point returning filtered vacancies
    When I request "/api/vacancy?country=1&city=2" using HTTP "GET"
    Then the response code is 200
    And the response body is an empty JSON array

  Scenario: Check that end-point returning vacancy by id
    When I request "/api/vacancy/1" using HTTP "GET"
    Then the response code is 200
    And the response body matches:
    """
    /"id":1,/i
    """
