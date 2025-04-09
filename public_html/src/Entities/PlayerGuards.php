<?PHP

/* Entity for table poll_answer */

namespace src\Entities;

class PlayerGuards
{
  private int $id;
  private int $attack;
  private int $defense;
  private string $name;

  public function getId(): int
  {
    return $this->id;
  }
  public function setId(int $id): void
  {
    $this->id = $id;
  }
  public function getAttack(): int
  {
    return $this->attack;
  }
  public function setAttack(int $attack): void
  {
    $this->attack = $attack;
  }
  public function getDefense(): int
  {
    return $this->defense;
  }
  public function setDefense(int $defense): void
  {
    $this->defense = $defense;
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function setName(string $name): void
  {
    $this->name = $name;
  }
}