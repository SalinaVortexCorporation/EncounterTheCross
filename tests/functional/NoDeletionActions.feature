Feature: NoDeletionActions
  As a Leader
  I want to not be able to delete data
  So that I know no data is getting lost

  Background:
    Given I am logged in as a Leader

  Scenario Outline: Restrict Deletion Actions
    Given I am on the "<object_type>" List Page
    When I click on the action menu for an "<object_type>"
    Then I should not see a "<action>" action

    Examples:
      | object_type  | action  |
      | Events       | delete |
      | Locations    | delete |
      | LaunchPoints | delete |
      | Testimonies  | delete |
      | Leaders      | delete |