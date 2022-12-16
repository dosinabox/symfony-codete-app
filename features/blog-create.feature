Feature:
    In order to add a new blog post
    As an authenticated User
    I want to send new post data with title, content and list of tags included

    #TODO: combine login action to one function
    Scenario: Blog post added, updated and deleted successfully
        Given the "Content-Type" request header is "application/json"
        Given the request body is:
        """
        {
            "username": "dosinabox@gmail.com",
            "password": "123"
        }
        """
        When I request "/api/login_check" using HTTP POST
        Then I receive token
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
        Then I receive postID
        Given the request body is:
        """
        {
            "title": "Updated test post title",
            "content": "Updated test post content",
            "tags": [3,4]
        }
        """
        Given I update post
        Then the response code is 200
        Given I delete post
        Then the response code is 200
