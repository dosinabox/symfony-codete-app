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
            "tags": ["cats","dogs"]
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
            "tags": ["lizards"]
        }
        """
        When I update test post
        Then the response code is 200
        When I delete test post
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
            "tags": ["cats","dogs"]
        }
        """
        When I request "/blogposts" using HTTP POST
        Then the response code is 401

    Scenario: Blog post updated by author user (access granted)
        Given I log in with correct credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Cats",
            "content": "Cats are the best!",
            "tags": ["cats"]
        }
        """
        When I request "/blogposts/fc3b0519-6fc9-4461-9b63-44b7e05b9678" using HTTP POST
        Then the response code is 200

    Scenario: Blog post updated by author admin (access granted)
        Given admin log in with correct credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Cats",
            "content": "Cats are the best!",
            "tags": ["cats"]
        }
        """
        When I request "/blogposts/d93b4b2d-4659-4377-b3c6-f29eddb848d6" using HTTP POST
        Then the response code is 200

    Scenario: Blog post updated by non-author user (access denied)
        Given I log in with correct credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Cats",
            "content": "Cats are the best!",
            "tags": ["cats"]
        }
        """
        When I request "/blogposts/d93b4b2d-4659-4377-b3c6-f29eddb848d6" using HTTP POST
        Then the response code is 403

    Scenario: Blog post updated by non-author admin (access granted)
        Given admin log in with correct credentials
        Given the next request contains received token
        Given the request body is:
        """
        {
            "title": "Cats",
            "content": "Cats are the best!",
            "tags": ["cats"]
        }
        """
        When I request "/blogposts/fc3b0519-6fc9-4461-9b63-44b7e05b9678" using HTTP POST
        Then the response code is 200
