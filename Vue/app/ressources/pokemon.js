class Pokemon {
  constructor(id, name, hp, img, xp, attacks = []) {
    this.id = id;
    this.name = name;
    this.hp = hp;
    this.hpMax = hp;
    this.img = img;
    this.xp = xp;
    this.attacking = false;
    this.attacks = [];
    for (const a of attacks) {
      this.attacks.push(new Attack(a.idAttack, a.name, a.damages, a.description, a.accuracy));
    }
  }

  takeDamage(damage){
    this.hp = this.hp-damage;
  }
}
