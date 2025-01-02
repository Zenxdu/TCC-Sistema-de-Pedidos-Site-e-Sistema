pub fn add(left: usize, right: usize) -> usize {
    left + right
}

#[cfg(test)]
mod tests {
    use super::*;

    #[test]
    fn it_works() {
        let result = add(2, 2);
        assert_eq!(result, 4);
    }
}

use wasm_bindgen::prelude::*;

#[wasm_bindgen]
pub fn update_order(
    meat_qty: u32, 
    lettuce_qty: u32, 
    tomato_qty: u32, 
    bacon_qty: u32, 
    ham_qty: u32, 
    cheddar_qty: u32, 
    mozzarella_qty: u32, 
    sauce_qty: u32, 
    egg_qty: u32, 
    onions_qty: u32
) -> String {
    let mut svg = format!("<svg width=\"400\" height=\"{}\">", 50 * (2 + meat_qty + lettuce_qty + tomato_qty + bacon_qty + ham_qty + cheddar_qty + mozzarella_qty + sauce_qty + egg_qty + onions_qty));
    
    // Pão superior
    svg.push_str(&format!("<image href=\"images/bread_top.svg\" x=\"0\" y=\"0\" height=\"50\" width=\"400\"/>"));

    let mut y = 50;
    for _ in 0..meat_qty {
        svg.push_str(&format!("<image href=\"images/meat.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..lettuce_qty {
        svg.push_str(&format!("<image href=\"images/lettuce.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..tomato_qty {
        svg.push_str(&format!("<image href=\"images/tomato.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..bacon_qty {
        svg.push_str(&format!("<image href=\"images/bacon.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..ham_qty {
        svg.push_str(&format!("<image href=\"images/ham.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..cheddar_qty {
        svg.push_str(&format!("<image href=\"images/cheddar.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..mozzarella_qty {
        svg.push_str(&format!("<image href=\"images/mozzarella.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..sauce_qty {
        svg.push_str(&format!("<image href=\"images/sauce.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..egg_qty {
        svg.push_str(&format!("<image href=\"images/egg.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }
    for _ in 0..onions_qty {
        svg.push_str(&format!("<image href=\"images/onions.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
        y += 50;
    }

    // Pão inferior
    svg.push_str(&format!("<image href=\"images/bread_bottom.svg\" x=\"0\" y=\"{}\" height=\"50\" width=\"400\"/>", y));
    
    svg.push_str("</svg>");
    svg
}
