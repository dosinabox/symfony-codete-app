Feature:
    In order to add a new blog post
    As an authenticated User
    I want to send new post data with title, content and list of tags included

    Scenario: Blog post added, updated and deleted successfully
        Given I log in with correct credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Test post title",
            "content": "Test post content",
            "tags": [1,2]
        }
        """
        When I request "/blogposts" using HTTP POST
        Then the response code is 200
        Then I receive test postID
        Given the request body is:
        """
        {
            "title": "Updated test post title",
            "content": "Updated test post content",
            "tags": [3,4]
        }
        """
        Given I update test post
        Then the response code is 200
        Given I delete test post
        Then the response code is 200

    Scenario: Blog post not added (missing required field)
        Given I log in with correct credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Test post title"
        }
        """
        When I request "/blogposts" using HTTP POST
        Then the response code is 400

    Scenario: Blog post not added (access denied)
        Given I log in with incorrect credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Test post title",
            "content": "Test post content",
            "tags": [1,2]
        }
        """
        When I request "/blogposts" using HTTP POST
        Then the response code is 401
