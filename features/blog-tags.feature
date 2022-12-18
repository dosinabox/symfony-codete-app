Feature:
    In order to see blog posts with a specific tag
    As an anonymous user
    I want to get the list of posts ids and titles which have the tag added

    Scenario: Blog posts with existing tag exist
        When I request "/blogposts/cats"
        Then the response code is 200
        Then the response body is a JSON array with a length of at least 1

    Scenario: Blog posts with existing tag does not exist
        When I request "/blogposts/dogs"
        Then the response code is 200
        Then the response body contains JSON:
        """
        []
        """

    Scenario: Unknown tag
        When I request "/blogposts/unknown"
        Then the response code is 200
        Then the response body contains JSON:
        """
        []
        """
