class Pokemon {
  constructor(id, name, hp, img, /*attacks*/) {
    this.id = id;
    this.name = name;
    this.hp = hp;
    this.hpMax = hp;
    this.img = img;
    this.attacking = false;
    //this.attacks = attacks;
  }

  takeDamage(damage){
    this.hp = this.hp-damage;
  }
}
